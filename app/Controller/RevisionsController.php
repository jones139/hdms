<?php
App::uses('AppController', 'Controller');
/**
 * Revisions Controller
 *
 * @package       app.Controller
 * @property Revision $Revision
 * @property PaginatorComponent $Paginator
 */
class RevisionsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 * @param doc_id - return only revisions for document doc_id.
 * @param latest - return only the revisions for the documents (including drafts)
 * @param issued - return only the issuedrevisions
 *
 * @return void
 */
	public function index() {
		$this->Revision->recursive = 0;
		$this->Paginator->settings = array(
		   			      'conditions'=>array(),
					      'fields'=>array('*'));		
		if (isset($this->params[ 'named' ][ 'doc_id' ])) {
		   $this->Paginator->settings['conditions']['Revision.doc_id'] = 
		   		$this->params[ 'named' ][ 'doc_id' ];
		} 
		if (isset($this->params[ 'named' ][ 'latest' ])) { #FIXME - this doesn't work!
		   $this->Paginator->settings['group']='Revision.doc_id';
		   #$this->Paginator->settings['fields'][]='Revision.id';
		   $this->Paginator->settings['conditions']['Revision.id']='max(Revision.id)';
		} 
		if (isset($this->params[ 'named' ][ 'issued' ])) {
		   #$this->Paginator->settings['group']='Revision.doc_id';
		   #$this->Paginator->settings['fields'][]='Revision.id';
		   $this->Paginator->settings['conditions']['doc_status_id']=2;
		} 

		$this->set('revisions', $this->Paginator->paginate());
	}



/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Revision->exists($id)) {
			throw new NotFoundException(__('Invalid revision'));
		}
		$options = array('conditions' => array('Revision.' . $this->Revision->primaryKey => $id));
		$this->set('revision', $this->Revision->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Revision->create();
			if ($this->Revision->save($this->request->data)) {
				$this->Session->setFlash(__('The revision has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The revision could not be saved. Please, try again.'));
			}
		}
		$docs = $this->Revision->Doc->find('list');
		$users = $this->Revision->User->find('list');
		$docStatuses = $this->Revision->DocStatus->find('list');
		$this->set(compact('docs', 'users', 'docStatuses'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Revision->exists($id)) {
			throw new NotFoundException(__('Invalid revision'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Revision->save($this->request->data)) {
				$this->Session->setFlash(__('The revision has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The revision could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Revision.' . $this->Revision->primaryKey => $id));
			$this->request->data = $this->Revision->find('first', $options);
		}

	#################################	
	# Send the view the list of users
	$this->loadModel('Users');
	$users = $this->Users->find('list');

	#################################	
	# Send the view the list of responses
	$this->loadModel('Responses');
	$responses = $this->Responses->find('list');

	#################################	
	# Send the view the list of route list statuses
	$this->loadModel('RouteListStatuses');
	$routeListStatuses = $this->RouteListStatuses->find('list');

	###########################################################
	# Find the latest route list associated with this revision,
	#  which has not been cancelled (status not equal to 3).
	$this->loadModel('RouteLists');
	$options = array(
	                 'conditions' => array(
			 	      'revision_id' => $id,
				   #   'route_list_status_id !='=>3
				   ),
			 'order'=>'revision_id asc'
			);
	$routeListArr = $this->RouteLists->find('all',$options);
	$lastRouteList_id = end($routeListArr)['RouteLists']['id'];
	$lastRouteList_status = end($routeListArr)['RouteLists']['route_list_status_id'];

	#################################################################
	# Send the view the list of existing route list entries for the 
	#  latest route list
	$this->loadModel('RouteListEntries');
	$options = array('fields'=>array('user_id','response_id','response_date','response_comment'),
		         'conditions' => array(
			 	      'route_list_id' => $lastRouteList_id)
			);
	$routeListEntries = $this->RouteListEntries->find('all',$options);
	
	#####################################
	# Actually send the data to the view
	$this->set(compact('users', 
			   'responses',
			   'routeListStatuses',
			   'routeListEntries',
			   'routeListArr',
			   'lastRouteList_id',
			   'lastRouteList_status'
			   ));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Revision->id = $id;
		if (!$this->Revision->exists()) {
			throw new NotFoundException(__('Invalid revision'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Revision->delete()) {
			$this->Session->setFlash(__('The revision has been deleted.'));
		} else {
			$this->Session->setFlash(__('The revision could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}


/**
 * attach_file method
 *
 * @return void
 */
	public function attach_file($id) {
		if ($this->request->is(array('post','put'))) {
			if ($this->Revision->attach_file($this->request->data,$this->Auth->User())) {
				$this->Session->setFlash(__('File Uploaded.'));
				return $this->redirect(array('action' => 'edit',$id));
			} else {
				$this->Session->setFlash(__('File Upload Failed.'));
			}
		}
		$options = array('conditions' => array('Revision.' . $this->Revision->primaryKey => $id));
		$this->request->data = $this->Revision->find('first', $options);
	}



/**
 * check_in_file method
 *
 * @return void
 */
	public function checkin_file($id) {
		if ($this->request->is(array('post','put'))) {
			if ($this->Revision->checkin_file($this->request->data,$this->Auth->User())) {
				$this->Session->setFlash(__('File Uploaded.'));
				return $this->redirect(array('action' => 'edit',$id));
			} else {
				$this->Session->setFlash(__('File Upload Failed.'));
			}
		}
		$options = array('conditions' => array('Revision.' . $this->Revision->primaryKey => $id));
		$this->request->data = $this->Revision->find('first', $options);
	}


/**
 * checkout_file method
 *
 * @return void
 */
	public function checkout_file($id) {
	       $filepath = $this->Revision->checkout_file($id,$this->Auth->user());
	       if ($filepath) {
	       	  echo "<pre>".$filepath."</pre>";
	       	  $this->response->file(
			$filepath,
    	       		array('download' => true, 'name' => $this->Revision->filename)
		  );
		  return $this->response;
	       } else {
		  return $this->redirect(array('action' => 'edit',$id));
	       }
	}

/**
 * download_file method - download file without checking it out (ie just read-only view).
 *
 * @return void
 */
	public function download_file($id) {
	       $filepath = $this->Revision->get_filepath($id);
	       if ($filepath) {
	       	  echo "<pre>".$filepath."</pre>";
	       	  $this->response->file(
			$filepath,
    	       		array('download' => true, 'name' => $this->Revision->filename)
		  );
		  return $this->response;
	       } else {
		  return $this->redirect(array('action' => 'edit',$id));
	       }
	}



/**
 * cancel_download_file method
 *
 * @return void
 */
	public function cancel_checkout_file($id) {
	       $this->Revision->cancel_checkout_file($id);
	       return $this->redirect(array('action' => 'edit',$id));
	}


/**
 * create_new_revision
 *   create a new revision of document id $docid
 *   if named parameter 'major' is set a major revision is created,
 *     otherwise a minor revision is created.
 */
	public function create_new_revision($docid) {
	   $major_rev = false;
	   if (isset($this->params[ 'named' ][ 'major' ])) {
	      $major_rev = true;
	   } 
	   $this->Revision->create_new_revision($docid,$major_rev);
           return $this->redirect(array('controller'=>'docs',
					'action' => 'index'));
	}	

}
