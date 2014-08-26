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
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array('DebugKit.Toolbar','Session',
	       		   'Auth'=>array(
				'loginRedirect'=>array(
					'controller'=>'docs',
					'action'=>'index'
				),
				'logoutRedirect'=>array(
					'controller'=>'pages',
					'action'=>'display',
					'home'
				)
# FIXME - controller authorisation gives 'hdmsController not found' errors!!!
				#,'authorize' => array('Controller')
			   )
		);
		
	public $helpers = array('Session','Time');


	public function isAuthorized($user) {
	   # Admin can access every action.
	   if (isset($user['role_id']) && $user['rule_id'] == 1) {
	       return true;
           }
	   return false;
        }

	public function beforeFilter() {
	       # By default we allow unauthenticated users to do nothing...
	       # The individual controllers allow unauthenticated access
	       # where they need to.
 	       #$this->Auth->allow('index','view','download_file');
	       $this->Auth->allow(array());

	       $this->set('testing','testing');
	       $this->set('authUserData', $this->Auth->user());
	       #$this['authUserData']['isAdmin'] = $this->Users->isAdmin($this->Auth->user()['id']);

	       # Get detailed information about the logged in user (e.g. notifications for that user etc.)
	       Controller::loadModel('Notifications');
		$options = array('conditions' => array('Notifications.user_id' => $this->Auth->user('id'),
			   		      	       'Notifications.active' => 1));
		$this->set('authUserExtraData', $this->Notifications->find('all', $options));	    
	       }

	public function beforeRender() {
	}

	public function logDebug($data) {
	       if (isset($data)) {
	       	  CakeLog::write('debug',$data);
	       }
	}

}
