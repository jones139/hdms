<?php
App::uses('AppController', 'Controller');
/**
 * RouteListEntries Controller
 *
 * @property RouteListEntry $RouteListEntry
 * @property PaginatorComponent $Paginator
 */
class RouteListEntriesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->RouteListEntry->recursive = 0;
		$this->set('routeListEntries', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->RouteListEntry->exists($id)) {
			throw new NotFoundException(__('Invalid route list entry'));
		}
		$options = array('conditions' => array('RouteListEntry.' . $this->RouteListEntry->primaryKey => $id));
		$this->set('routeListEntry', $this->RouteListEntry->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->RouteListEntry->create();
			if ($this->RouteListEntry->save($this->request->data)) {
				$this->Session->setFlash(__('The route list entry has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The route list entry could not be saved. Please, try again.'));
			}
		}
		$routeLists = $this->RouteListEntry->RouteList->find('list');
		$users = $this->RouteListEntry->User->find('list');
		$responses = $this->RouteListEntry->Response->find('list');
		$this->set(compact('routeLists', 'users', 'responses'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->RouteListEntry->exists($id)) {
			throw new NotFoundException(__('Invalid route list entry'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->RouteListEntry->save($this->request->data)) {
				$this->Session->setFlash(__('The route list entry has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The route list entry could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('RouteListEntry.' . $this->RouteListEntry->primaryKey => $id));
			$this->request->data = $this->RouteListEntry->find('first', $options);
		}
		$routeLists = $this->RouteListEntry->RouteList->find('list');
		$users = $this->RouteListEntry->User->find('list');
		$responses = $this->RouteListEntry->Response->find('list');
		$this->set(compact('routeLists', 'users', 'responses'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->RouteListEntry->id = $id;
		if (!$this->RouteListEntry->exists()) {
			throw new NotFoundException(__('Invalid route list entry'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->RouteListEntry->delete()) {
			$this->Session->setFlash(__('The route list entry has been deleted.'));
		} else {
			$this->Session->setFlash(__('The route list entry could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
