<?php
App::uses('AppController', 'Controller');
/**
 * DocStatuses Controller
 *
 * @package       app.Controller
 * @property DocStatus $DocStatus
 * @property PaginatorComponent $Paginator
 */
class DocStatusesController extends AppController {

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
		$this->DocStatus->recursive = 0;
		$this->set('docStatuses', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->DocStatus->exists($id)) {
			throw new NotFoundException(__('Invalid doc status'));
		}
		$options = array('conditions' => array('DocStatus.' . $this->DocStatus->primaryKey => $id));
		$this->set('docStatus', $this->DocStatus->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->DocStatus->create();
			if ($this->DocStatus->save($this->request->data)) {
				$this->Session->setFlash(__('The doc status has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The doc status could not be saved. Please, try again.'));
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
		if (!$this->DocStatus->exists($id)) {
			throw new NotFoundException(__('Invalid doc status'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->DocStatus->save($this->request->data)) {
				$this->Session->setFlash(__('The doc status has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The doc status could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('DocStatus.' . $this->DocStatus->primaryKey => $id));
			$this->request->data = $this->DocStatus->find('first', $options);
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
		$this->DocStatus->id = $id;
		if (!$this->DocStatus->exists()) {
			throw new NotFoundException(__('Invalid doc status'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->DocStatus->delete()) {
			$this->Session->setFlash(__('The doc status has been deleted.'));
		} else {
			$this->Session->setFlash(__('The doc status could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
