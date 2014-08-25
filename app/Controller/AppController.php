<?php
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
			   )
		);
		
	public $helpers = array('Session','Time');


	public function logDebug($data) {
	       if (isset($data)) {
	       	  CakeLog::write('debug',$data);
	       }
	}

	public function beforeFilter() {
 	       $this->Auth->allow('index','view','download_file');
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

}
