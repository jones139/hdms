<?php
App::uses('AppController', 'Controller');
/**
 * Revisions Controller
 *
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
 *
 * @return void
 */
	public function index() {
		$this->Revision->recursive = 0;
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
		$routeLists = $this->Revision->RouteList->find('list');
		$this->set(compact('docs', 'users', 'docStatuses', 'routeLists'));
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
		$docs = $this->Revision->Doc->find('list');
		$users = $this->Revision->User->find('list');
		$docStatuses = $this->Revision->DocStatus->find('list');
		$routeLists = $this->Revision->RouteList->find('list');
		$this->set(compact('docs', 'users', 'docStatuses', 'routeLists'));
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
}
