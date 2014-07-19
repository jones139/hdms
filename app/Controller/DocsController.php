<?php
App::uses('AppController', 'Controller');
/**
 * Docs Controller
 *
 * @property Doc $Doc
 * @property PaginatorComponent $Paginator
 */
class DocsController extends AppController {

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
		$this->Doc->recursive = 0;
		$this->set('docs', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Doc->exists($id)) {
			throw new NotFoundException(__('Invalid doc'));
		}
		$options = array('conditions' => array('Doc.' . $this->Doc->primaryKey => $id));
		$this->set('doc', $this->Doc->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Doc->create();
			if ($this->Doc->save($this->request->data)) {
				$this->Session->setFlash(__('The doc has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The doc could not be saved. Please, try again.'));
			}
		}
		$facilities = $this->Doc->Facility->find('list');
		$this->set(compact('facilities'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Doc->exists($id)) {
			throw new NotFoundException(__('Invalid doc'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Doc->save($this->request->data)) {
				$this->Session->setFlash(__('The doc has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The doc could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Doc.' . $this->Doc->primaryKey => $id));
			$this->request->data = $this->Doc->find('first', $options);
		}
		$facilities = $this->Doc->Facility->find('list');
		$this->set(compact('facilities'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Doc->id = $id;
		if (!$this->Doc->exists()) {
			throw new NotFoundException(__('Invalid doc'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Doc->delete()) {
			$this->Session->setFlash(__('The doc has been deleted.'));
		} else {
			$this->Session->setFlash(__('The doc could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
