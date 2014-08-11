<?php
App::uses('AppController', 'Controller');
/**
 * DocTypes Controller
 *
 * @package       app.Controller
 * @property DocType $DocType
 * @property PaginatorComponent $Paginator
 */
class DocTypesController extends AppController {

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
		$this->DocType->recursive = 0;
		$this->set('docTypes', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->DocType->exists($id)) {
			throw new NotFoundException(__('Invalid doc type'));
		}
		$options = array('conditions' => array('DocType.' . $this->DocType->primaryKey => $id));
		$this->set('docType', $this->DocType->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->DocType->create();
			if ($this->DocType->save($this->request->data)) {
				$this->Session->setFlash(__('The doc type has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The doc type could not be saved. Please, try again.'));
			}
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
		if (!$this->DocType->exists($id)) {
			throw new NotFoundException(__('Invalid doc type'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->DocType->save($this->request->data)) {
				$this->Session->setFlash(__('The doc type has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The doc type could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('DocType.' . $this->DocType->primaryKey => $id));
			$this->request->data = $this->DocType->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->DocType->id = $id;
		if (!$this->DocType->exists()) {
			throw new NotFoundException(__('Invalid doc type'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->DocType->delete()) {
			$this->Session->setFlash(__('The doc type has been deleted.'));
		} else {
			$this->Session->setFlash(__('The doc type could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
