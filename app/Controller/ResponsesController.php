<?php
App::uses('AppController', 'Controller');
/**
 * Responses Controller
 *
 * @package       app.Controller
 * @property Response $Response
 * @property PaginatorComponent $Paginator
 */
class ResponsesController extends AppController {

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
		$this->Response->recursive = 0;
		$this->set('responses', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Response->exists($id)) {
			throw new NotFoundException(__('Invalid response'));
		}
		$options = array('conditions' => array('Response.' . $this->Response->primaryKey => $id));
		$this->set('response', $this->Response->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Response->create();
			if ($this->Response->save($this->request->data)) {
				$this->Session->setFlash(__('The response has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The response could not be saved. Please, try again.'));
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
		if (!$this->Response->exists($id)) {
			throw new NotFoundException(__('Invalid response'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Response->save($this->request->data)) {
				$this->Session->setFlash(__('The response has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The response could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Response.' . $this->Response->primaryKey => $id));
			$this->request->data = $this->Response->find('first', $options);
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
		$this->Response->id = $id;
		if (!$this->Response->exists()) {
			throw new NotFoundException(__('Invalid response'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Response->delete()) {
			$this->Session->setFlash(__('The response has been deleted.'));
		} else {
			$this->Session->setFlash(__('The response could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
