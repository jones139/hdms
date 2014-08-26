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
 * Notifications Controller
 *
 * @package       app.Controller
 * @property Notification $Notification
 * @property PaginatorComponent $Paginator
 */
class NotificationsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method - by default lists all notifications. 
 *                if a user_id GET parameter is provided, it lists only the active notifications
 *                  for the given user_id.
 *
 * @return void
 */
	public function index() {
		$this->Notification->recursive = 2;
		#echo "<pre>".var_dump($this->params)."</pre>";
		if (isset($this->params[ 'named' ][ 'user_id' ])) {
		   $user_id = $this->params[ 'named' ][ 'user_id' ];
		   $this->Paginator->settings = array(
		   			      'conditions'=>array('Notification.user_id'=>$user_id,
								  'Notification.active'=>1)
							);
		} 
 		   $this->set('notifications', $this->Paginator->paginate());
  	
	}

/**
 * view method - by default views the notification specified by $id. 
 *
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Notification->exists($id)) {
			throw new NotFoundException(__('Invalid notification'));
		}
		$options = array('conditions' => array('Notification.' . $this->Notification->primaryKey => $id));
		$this->set('notification', $this->Notification->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Notification->create();
			if ($this->Notification->save($this->request->data)) {
				$this->Session->setFlash(__('The notification has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The notification could not be saved. Please, try again.'));
			}
		}
		$users = $this->Notification->User->find('list');
		$revisions = $this->Notification->Revision->find('list');
		$this->set(compact('users', 'revisions'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Notification->exists($id)) {
			throw new NotFoundException(__('Invalid notification'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Notification->save($this->request->data)) {
				$this->Session->setFlash(__('The notification has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The notification could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Notification.' . $this->Notification->primaryKey => $id));
			$this->request->data = $this->Notification->find('first', $options);
		}
		$users = $this->Notification->User->find('list');
		$revisions = $this->Notification->Revision->find('list');
		$this->set(compact('users', 'revisions'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Notification->id = $id;
		if (!$this->Notification->exists()) {
			throw new NotFoundException(__('Invalid notification'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Notification->delete()) {
			$this->Session->setFlash(__('The notification has been deleted.'));
		} else {
			$this->Session->setFlash(__('The notification could not be deleted. Please, try again.'));
		}
		return $this->redirect($this->referer());
	}
}
