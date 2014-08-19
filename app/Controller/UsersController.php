<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @package       app.Controller
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

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
	       if ($this->Auth->user('role_id')==1) {
		  $this->User->recursive = 0;
		  $this->set('users', $this->Paginator->paginate());
	       } else {
		  $this->Session->setFlash(__('Only an Administrator can do that! - your role is '.$this->Auth->User('role_id').'.'));
		  return $this->redirect($this->referer());          
 	       }
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
	       if ($this->Auth->user('role_id')==1 or
	         $id == $this->Auth->user('id')) {
		   if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		   }
		   $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		   $this->set('user', $this->User->find('first', $options));
	       } else {
		  $this->Session->setFlash(__('Only an Administrator can do that! - your role is '.$this->Auth->User('role_id').'.'));
		  return $this->redirect($this->referer());          
	       }
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
	    if ($this->Auth->user('role_id')==1) {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$roles = $this->User->Role->find('list');
		$this->set(compact('roles'));
            } else {
		  $this->Session->setFlash(__('Only an Administrator can do that! - your role is '.$this->Auth->User('role_id').'.'));
		  return $this->redirect($this->referer());          
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
	   if ($this->Auth->user('role_id')==1 or
	       $id == $this->Auth->user('id')) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$roles = $this->User->Role->find('list');
		$this->set(compact('roles'));
            } else {
		  $this->Session->setFlash(__('Only an Administrator can do that! - your role is '.$this->Auth->User('role_id').'.'));
		  return $this->redirect($this->referer());          
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
	    if ($this->Auth->user('role_id')==1) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
            } else {
		  $this->Session->setFlash(__('Only an Administrator can do that! - your role is '.$this->Auth->User('role_id').'.'));
		  return $this->redirect($this->referer());          
	    }

	}

	public function beforeFilter() {
	       parent::beforeFilter();
	       $this->Auth->allow('add','login','logout');
	}

	public function login() {
	       if ($this->request->is('post')) {
	       	  if ($this->Auth->login()) {
		     $this->Session->setFlash(__('Login Successful'));
		     return($this->redirect(array(
					'controller'=>'docs',
					'action'=>'index'
				)));
		  }
		  $this->Session->setFlash(__('Invalid username or password'));
	       }
	}

	public function logout() {
	       return($this->redirect($this->Auth->logout()));
	}
}


