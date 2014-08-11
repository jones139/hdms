<?php
App::uses('AppController', 'Controller');
/**
 * DocSubtypes Controller
 *
 * @package       app.Controller
 * @property DocSubtype $DocSubtype
 * @property PaginatorComponent $Paginator
 */
class DocSubtypesController extends AppController {

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
		$this->DocSubtype->recursive = 0;
		$this->set('docSubtypes', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->DocSubtype->exists($id)) {
			throw new NotFoundException(__('Invalid doc subtype'));
		}
		$options = array('conditions' => array('DocSubtype.' . $this->DocSubtype->primaryKey => $id));
		$this->set('docSubtype', $this->DocSubtype->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->DocSubtype->create();
			if ($this->DocSubtype->save($this->request->data)) {
				$this->Session->setFlash(__('The doc subtype has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The doc subtype could not be saved. Please, try again.'));
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
		if (!$this->DocSubtype->exists($id)) {
			throw new NotFoundException(__('Invalid doc subtype'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->DocSubtype->save($this->request->data)) {
				$this->Session->setFlash(__('The doc subtype has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The doc subtype could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('DocSubtype.' . $this->DocSubtype->primaryKey => $id));
			$this->request->data = $this->DocSubtype->find('first', $options);
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
		$this->DocSubtype->id = $id;
		if (!$this->DocSubtype->exists()) {
			throw new NotFoundException(__('Invalid doc subtype'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->DocSubtype->delete()) {
			$this->Session->setFlash(__('The doc subtype has been deleted.'));
		} else {
			$this->Session->setFlash(__('The doc subtype could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
