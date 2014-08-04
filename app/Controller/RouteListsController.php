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

	#public $uses = array('Revisions');

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
                } else {
		   $this->Session->setFlash(
		       __('No Revision ID specified - routelist NOT created.'));
		   $this->redirect($this->referer());
                }
	}

/**
 * add_approver method - adds an approver (route list entry) to 
 *  a route list.
 *
 * @return void
 */
	public function add_approver($id=null) {
	        $this->RouteList->recursive = 2;
		if (!$this->RouteList->exists($id)) {
			throw new NotFoundException(__('Invalid route list'));
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
}
