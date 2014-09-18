<?php
/***************************************************************************
 *   This file is part of HDMS.
 *
 *   Copyright 2014, Graham Jones (grahamjones@physics.org)
 *
 *   HDMS is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   Foobar is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with HDMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 ****************************************************************************/

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
            $this->Session->setFlash(__('Only an Administrator can list'.
            ' users!'));
            # $this->Auth->User('role_id')
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
            $this->Session->setFlash(__('Only an Administrator can do that!'));
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
                # Check passwords both match - manual fiddle rather than
                # a proper cakephp validation rule...
                if ($this->request->data[ 'User' ][ 'password' ] 
                != $this->request->data[ 'User' ][ 'confirm_password' ] ) {
                    # passwords do not match, so invalidate them on the form.
                    $this->User->invalidate( 'password', 
                    "The passwords don't match." );
                    $this->User->invalidate( 'confirm_password', 
                    "The passwords don't match." );
                } else {  # Passwords match, so create user record
                    $this->User->create();
                    if ($this->User->save($this->request->data)) {
                        $this->Session->setFlash(__('The user has been saved.'));
                        return $this->redirect(array('action' => 'index'));
                    } else {
                        $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
                    }
                }
            }
            $roles = $this->User->Role->find('list');
            $positions = $this->User->Position->find('list');
            $this->set(compact('roles','positions'));
        } else {
            $this->Session->setFlash(__('Only an Administrator can do that!'));
            return $this->redirect($this->referer());          
        }
    }
    
/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id - user_id of user to edit.
 * @return void
 */
    public function edit($id = null) {
        # Only an administrator or the user him/herself can edit user data.
        if ($this->Auth->user('role_id')==1 or
        $id == $this->Auth->user('id')) {
            if (!$this->User->exists($id)) {
                throw new NotFoundException(__('Invalid user'));
            }
            # Have we been sent some data?
            if ($this->request->is(array('post', 'put'))) {
                # Check passwords both match - manual fiddle rather than
                # a proper cakephp validation rule...
                if ($this->request->data[ 'User' ][ 'password' ] 
                != $this->request->data[ 'User' ][ 'confirm_password' ] ) {
                    # passwords do not match, so invalidate them on the form.
                    $this->User->invalidate( 'password', 
                    "The passwords don't match." );
                    $this->User->invalidate( 'confirm_password', 
                    "The passwords don't match." );
                } else {  // Passwords match, so save data
                    // if we have provided a password
                    // clear the require_new_password flag.
                    // Unless we are an administrator editing another user's
                    // data, in which case we still want the user to change
                    // the password.
                    if (!empty($this->request->data['User']['password']) and
                       $this->Auth->User('id')==
                       $this->request->data['User']['id']) {
                        $this->request->data['User']['require_new_password'] = false;
                        $this->logDebug("resetting require_new_password - auth_id=".$this->Auth->User('id')." editing user ".$this->request->data['User']['id']);
                    } else {
                        $this->logDebug( "Not changing require_new_password - auth_id=".
                        $this->Auth->User('id')." editing user ".$this->request->data['User']['id']);
                    }
                    if ($this->User->save($this->request->data)) {
                        $this->Session->setFlash(__('The user has been saved.  Log out and in again for changes to take effect.'));
                        if ($this->Auth->user('role_id')==1) {
                            return $this->redirect(array('action' => 'index'));
                        }
                        else {
                            return $this->redirect(array('controller'=>'docs',
                            'action' => 'index'));
                        }
                    } else {
                        $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
                    }
                    
		} 
            }
            $options = array('conditions' => array(
                'User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
            # Do not pre-populate the password field.
            unset($this->request->data['User']['password']);
            
            $roles = $this->User->Role->find('list');
            $positions = $this->User->Position->find('list');
            $this->set(compact('roles','positions'));
        } else {
            $this->Session->setFlash(__('Only an Administrator can do that!'));
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
            $this->Session->setFlash(__('Only an Administrator can do that!'));
            return $this->redirect($this->referer());          
        }
        
    }

    public function beforeFilter() {
        parent::beforeFilter();
        # The only thing an un-authenticated user can do is login.
        $this->Auth->allow('login');
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
        $this->Session->setFlash(__('Logged out ok.'));
        return($this->redirect($this->Auth->logout()));
    }
}

