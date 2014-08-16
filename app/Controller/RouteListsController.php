<?php
App::uses('AppController', 'Controller');
/**
 * RouteLists Controller
 *
 * @property RouteList $RouteList
 * @property PaginatorComponent $Paginator
 */
class RouteListsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	#public $uses = array('Users');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->RouteList->recursive = 0;
		$this->set('routeLists', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->RouteList->exists($id)) {
			throw new NotFoundException(__('Invalid route list'));
		}
		$options = array('conditions' => array('RouteList.' . $this->RouteList->primaryKey => $id));
		$this->set('routeList', $this->RouteList->find('first', $options));
	}

/**
 * add method - expects a named parameter 'revision' which is the revision id
 *    to which this route list should be associated.
 *
 * @return void
 */
	public function add() {
	        $this->RouteList->recursive = 2;
	        if (isset($this->params[ 'named' ][ 'revision' ])) {
	           Controller::loadModel('Revisions');
		   $revision_id = $this->params['named']['revision'];
		   if (!$this->Revisions->exists($revision_id)) {
			$this->Session->setFlash(__('Invalid Revision id '.$revision_id.'.  Route list NOT created.'));
			$this->redirect($this->referer());
		   }
		   echo "<pre>".$revision_id."</pre>";
		   $rev = $this->Revisions->findById($revision_id);
		   echo "<pre>".var_dump($rev)."</pre>";
		   #$active = $this->Revisions->has_active_routelist($revision_id);
		   $routelist_data = array('revision_id'=>$revision_id);
		   $this->RouteList->create();
		   $this->RouteList->save($routelist_data);
		   $this->Session->setFlash(__('Route List Created ok.'));
		   $id = $this->RouteList->GetInsertID();
		   $data = $this->RouteList->findById($id);
		   $this->set(array('data'=>$data));
		   $this->redirect(array('controller'=>'route_lists',
					'action'=>'add_approver',
					$id));
                } else {
		   $this->Session->setFlash(
		       __('No Revision ID specified - routelist NOT created.'));
		   $this->redirect($this->referer());
                }
	}


/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
	        #$this->RouteListEntries->recursive = 2;
		if (!$this->RouteList->exists($id)) {
			throw new NotFoundException(__('Invalid route list'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->RouteList->save($this->request->data)) {
				$this->Session->setFlash(__('The route list has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The route list could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('RouteList.' . $this->RouteList->primaryKey => $id));
			$this->request->data = $this->RouteList->find('first', $options);
		}
		$revisions = $this->RouteList->Revision->find('list');
		$this->set(compact('revisions'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->RouteList->id = $id;
		if (!$this->RouteList->exists()) {
			throw new NotFoundException(__('Invalid route list'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->RouteList->delete()) {
			$this->Session->setFlash(__('The route list has been deleted.'));
		} else {
			$this->Session->setFlash(__('The route list could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}


/**
 * add_approver method - adds an approver (route list entry) to 
 *  a route list.
 *
 * @return void
 */
	public function add_approver($id=null) {
	        #$this->RouteListEntries->recursive = 1;
		if (!$this->RouteList->exists($id)) {
			throw new NotFoundException(__('Invalid route list'));
		}
		if ($this->request->is(array('post', 'put'))) {
	           $this->loadModel('RouteListEntry');
		   echo "<pre>".var_dump($this->request->data)."</pre>";
		   $this->RouteListEntry->create();
		   if ($this->RouteListEntry->save($this->request->data)) {
			$this->Session->setFlash(__('Approver Added.'));
			return $this->redirect(array('controller'=>'route_lists','action'=>'add_approver',$this->request->data['RouteListEntry']['route_list_id']));
			} else {
				$this->Session->setFlash(__('The approver could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = array('RouteListEntry'=>array('route_list_id'=>$id));

		}

	# Send the view the list of users
	$this->loadModel('Users');
	$users = $this->Users->find('list');

	# Send the view the list of existing route list entries
	$this->loadModel('RouteListEntries');
	$options = array('fields'=>array('user_id'),'conditions' => array('route_list_id' => $id));
	$entries = $this->RouteListEntries->find('list',$options);

	# Send the view the id of the revision associated with this route list.
	$options = array('fields'=>array('revision_id'),'conditions' => array('RouteList.id' => $id));
	$rev_arr = $this->RouteList->find('first',$options);
	$revision_id = $rev_arr['RouteList']['revision_id'];

	$this->set(compact('users','entries','revision_id'));
        }


/**
 * delete_approver method - delete the route_list_entry $id
 */
	public function delete_approver($id=null) {
	        $this->loadModel('RouteListEntry');
		$this->RouteListEntry->id = $id;

		$options = array('conditions' => array('RouteListEntry.id' => $id));
		$rle = $this->RouteListEntry->find('first', $options);
		$routeList_id = $rle['RouteListEntry']['route_list_id'];

		if (!$this->RouteListEntry->exists()) {
			throw new NotFoundException(__('Invalid route list entry'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->RouteListEntry->delete()) {
			$this->Session->setFlash(__('The route list entry has been deleted.'));
		} else {
			$this->Session->setFlash(__('The route list entry could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'add_approver',$routeList_id));
	}


/**
 * submit method - submits a route list for approval and notifies the
 *   approvers.
 *
 * @return void
 */
	public function submit($id=null) {
		if (!$this->RouteList->exists($id)) {
			throw new NotFoundException(__('Invalid route list'));
		}
		if ($this->request->is(array('post', 'put'))) {
		   	$this->request->data['RouteList']['route_list_status_id']=1;
			if ($this->RouteList->save($this->request->data)) {
				$this->Session->setFlash(__('The route list submited'));
				$this->_notify_route_list_approvers($id);
				return $this->redirect(array('controller'=>'revisions','action'=>'edit',$this->request->data['RouteList']['revision_id']));
                       } else {
				$this->Session->setFlash(
				   __('Oh no, failed to submit route list - dont know why!!!'));
				return $this->redirect(
				   array('controller'=>'revisions',
                                         'action'=>'edit',
                                         $this->request->data['RouteList']['revision_id']));
                       }
		} else {
			$options = array('conditions' => array('RouteList.' . $this->RouteList->primaryKey => $id));
			$this->request->data = $this->RouteList->find('first', $options);
		}
		#$revisions = $this->RouteList->Revision->find('list');
		#$this->set(compact('revisions'));
	}

/**
 * cancel method - cancels a route list and removes notifications for 
 *     approvers.
 *
 * @return void
 */
	public function cancel($id=null) {
		if (!$this->RouteList->exists($id)) {
			throw new NotFoundException(__('Invalid route list'));
		}

		if ($this->request->is(array('post', 'put'))) {
		   	$this->request->data['RouteList']['route_list_status_id']=3;
			if ($this->RouteList->save($this->request->data)) {
			   $this->_remove_route_list_notifications($id);
			   $this->Session->setFlash(__('The route list cancelled'));
			   return $this->redirect(array('controller'=>'revisions','action'=>'edit',$this->request->data['RouteList']['revision_id']));
                       } else {
				$this->Session->setFlash(
				   __('Oh no, failed to cancel route list - dont know why!!!'));
				return $this->redirect(
				   array('controller'=>'revisions',
                                         'action'=>'edit',
                                         $this->request->data['RouteList']['revision_id']));
                       }
		} else {
			$options = array('conditions' => array('RouteList.' . $this->RouteList->primaryKey => $id));
			$this->request->data = $this->RouteList->find('first', $options);
		}

	}


	/*
	 * approve method - approve route list $id as the current user.
	 *
	 */
	 public function approve($id = null) {
	        $this->RouteList->recursive = 2;  #Needed to make sure we get Doc data in query.
	        $this->loadModel('RouteListEntry');
	        $this->loadModel('Responses');
	        $this->RouteListEntry->recursive = 3;  #Needed to make sure we get revision data in query.
		#
		# Check that the route list we are approving actually exists...
		if (!$this->RouteList->exists($id)) {
			throw new NotFoundException(__('Invalid route list'));
		}
		#
		# If we are submitting form data ('post'), process it.
		if ($this->request->is(array('post', 'put'))) {
		   # Find route list entry data.
		   $options = array('conditions' => 
		   	    array('RouteListEntry.route_list_id' => $id));
		   $rle = $this->RouteListEntry->find('first', $options);
		   $this->request->data['RouteListEntry']['response_date'] = 
		   					date('Y-m-d H:i:s');
		   #
     		   # Save the data
		   if ($this->RouteListEntry->save($this->request->data)) {
		   
		      if ($this->RouteList->isComplete($id)) {
		      	 if ($this->RouteList->isApproved($id)) {
		            $this->Session->setFlash(
				   __('Response Accepted - Revision Issued'));		         
			 } else {
		            $this->Session->setFlash(
				   __('Response Accepted - Revision Rejected'));		         
		         }
		      } else {
		      $this->Session->setFlash(
				   __('Response Accepted -  waiting for other reviewers'));
		      }
		   } else {
		      $this->Session->setFlash(
				   __('Failed to update approval status - please try again!'));
		   }
		   return $this->redirect(
			array('controller'=>'revisions',
                                         'action'=>'edit',
                                        $rle['RouteList']['revision_id']));
		} else {
		  $options = array('conditions' => 
		  	   array('RouteListEntry.route_list_id' => $id,
		  	         'RouteListEntry.user_id'=>
						$this->Auth->user('id')));
		  $this->request->data = $this->RouteListEntry->
						find('first', $options);
		  # 
		  # Check we are actually being asked to approve this revision.
		  if (!$this->request->data) {
		      $this->Session->setFlash(
				   __('You are not being asked to approve this revision! How did you get here???'));
		      return $this->redirect($this->referer());

		  }
		  $responses = $this->Responses->find('list');
		  $this->set(compact('responses'));
   		}		
	 }

	/* 
	* Send a notification to each approver on route list $id to ask them to approve
	* the revision
	*/
	public function _notify_route_list_approvers($id=null) {
	   $this->loadModel('Notification');
	   $this->loadModel('RouteListEntry');
	   if (!$this->RouteList->exists($id)) {
	      throw new NotFoundException(__('Invalid route list'));
	   }
	   $options = array('conditions' => array('RouteListEntry.route_list_id' => $id),
	   	            'fields' => array('user_id'));
	   $userlist = $this->RouteListEntry->find('list', $options);
	   $options = array('conditions' => array('RouteList.id' => $id),
	   	            'fields' => array('revision_id'));
	   $revisionArr = $this->RouteList->find('list', $options);
	   $revision_id = reset($revisionArr);  # get first element
	   foreach ($userlist as $user_id) {
	       $this->Notification->send($user_id,$revision_id,"Please Approve Revision");	   
           }
           $this->set(compact('userlist','revisionArr','revision_id'));
        } 

	/* 
	* remove notification for each approver on route list $id asking them to approve
	* the revision
	*/
	public function _remove_route_list_notifications($id=null) {
	   $this->loadModel('Notification');
	   $this->loadModel('RouteListEntry');
	   if (!$this->RouteList->exists($id)) {
	      throw new NotFoundException(__('Invalid route list'));
	   }
	   $options = array('conditions' => array('RouteListEntry.route_list_id' => $id),
	   	            'fields' => array('user_id'));
	   $userlist = $this->RouteListEntry->find('list', $options);
	   $options = array('conditions' => array('RouteList.id' => $id),
	   	            'fields' => array('revision_id'));
	   $revisionArr = $this->RouteList->find('list', $options);
	   $revision_id = reset($revisionArr);  # get first element
	   foreach ($userlist as $user_id) {
	       $this->Notification->cancel($user_id,$revision_id,"Please Approve Revision");	   
           }
           $this->set(compact('userlist','revisionArr','revision_id'));
        } 


}
