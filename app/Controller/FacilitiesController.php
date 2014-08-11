<?php
App::uses('AppController', 'Controller');
/**
 * Facilities Controller
 *
 * @package       app.Controller
 * @property Facility $Facility
 * @property PaginatorComponent $Paginator
 */
class FacilitiesController extends AppController {

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
		$this->Facility->recursive = 0;
		$this->set('facilities', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Facility->exists($id)) {
			throw new NotFoundException(__('Invalid facility'));
		}
		$options = array('conditions' => array('Facility.' . $this->Facility->primaryKey => $id));
		$this->set('facility', $this->Facility->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Facility->create();
			if ($this->Facility->save($this->request->data)) {
				$this->Session->setFlash(__('The facility has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The facility could not be saved. Please, try again.'));
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
		if (!$this->Facility->exists($id)) {
			throw new NotFoundException(__('Invalid facility'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Facility->save($this->request->data)) {
				$this->Session->setFlash(__('The facility has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The facility could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Facility.' . $this->Facility->primaryKey => $id));
			$this->request->data = $this->Facility->find('first', $options);
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
		$this->Facility->id = $id;
		if (!$this->Facility->exists()) {
			throw new NotFoundException(__('Invalid facility'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Facility->delete()) {
			$this->Session->setFlash(__('The facility has been deleted.'));
		} else {
			$this->Session->setFlash(__('The facility could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
