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

App::uses('AppModel', 'Model');
/**
 * Notification Model
 *
 * @package       app.Model
 * @property User $User
 * @property Revision $Revision
 */
class Notification extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Revision' => array(
			'className' => 'Revision',
			'foreignKey' => 'revision_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


	/**
	* Send notification to user $user_id, refering to revision 
        * $revision_id with message $message.
        * $nType is the notification type default 0 = approve, or 1 = for info.
	*/
	public function send($user_id,$revision_id,$message,$nType = 0) {
	  $retval = array();
	  $data = array('user_id'=>$user_id,
			'revision_id'=>$revision_id,
			'body_text'=>$message,
			'sent_date'=>date('Y-m-d H:i:s'),
			'notification_type_id'=>$nType,
			'active'=>true
			);
	  $this->create();
	  $this->save($data);
	  
	  App::import('Model','Setting');
	  $SettingsModel = new Setting();
	  $settings = $SettingsModel->findById(1)['Setting'];
	  
	  #########################################
	    # Send email notification
	  if ($settings['email_enabled']) {
	    $user = $this->User->findById($user_id);
	    if ($user['User']['email_verified']) {
	      $email = $user['User']['email'];
	      $bodyTxt = "Please Approve document ".
		Router::url(array(
				  'controller'=>'revisions',
				  'action'=>'edit',
				  $revision_id),true).
		".\n".$this->getDocInfo($revision_id);
	      mail($email,"HDMS Notification",$bodyTxt);
	    }
	  }
	}

	/**
	* Cancel notification to a user, refering to revision $revision_id
	*/
	public function cancel($user_id,$revision_id) {
	       $notifications = $this->find('all', array(
    	       		      'conditions'=> array(
        		      		     'Notification.user_id' => $user_id,
			      		     'Notification.revision_id' => $revision_id
    			      )));
	       foreach($notifications as $not) {
	           $this->id = $not['Notification']['id'];
    	       	   $this->saveField('active', false);
	       }
        }

	public function issue_notify($revision_id) {
	  App::import('Model','Setting');
	  $SettingsModel = new Setting();
	  $settings = $SettingsModel->findById(1)['Setting'];
	  //#########################################
	  // Send email notification
	  if ($settings['email_enabled']) {
	    $emailArr = explode(';',$settings['issue_notify_list']);
	    foreach ($emailArr as $email) {
	      $bodyTxt = "For Information:  HDMS Document has been issued: ".
		Router::url(array(
				  'controller'=>'revisions',
				  'action'=>'edit',
				  $revision_id),true).
		".\n".$this->getDocInfo($revision_id);
	      mail($email,"HDMS Notification",$bodyTxt);
	    }
	  }
	}
	

	public function response_notify($email,$revision_id) {
	  App::import('Model','Setting');
	  $SettingsModel = new Setting();
	  $settings = $SettingsModel->findById(1)['Setting'];
	  //#########################################
	  // Send email notification
	  if ($settings['email_enabled']) {
	      $bodyTxt = "For Information:  A user has responded to HDMS Document Approval Request: ".
		Router::url(array(
				  'controller'=>'revisions',
				  'action'=>'edit',
				  $revision_id),true).
		".\n".$this->getDocInfo($revision_id);
	      $this->logDebug("response_notify: Sending Email to ".$email);
	      mail($email,"HDMS Notification",$bodyTxt);
	  }
	}

	public function getDocInfo($revisionId = null) {
	  App::import('Model','Revision');
	  $Revision = new Revision();

	  $this->Revision->recursive = 3;
	  $rev = $Revision->findById($revisionId);

	  $docInfo = $rev['Doc']['title'].
	    ' ('.
	    $rev['Doc']['docNo'].
	    ') Revision '.
	    $rev['Revision']['major_revision'].
	    '_'.
	    $rev['Revision']['minor_revision'];
	  return $docInfo;
	    
	}

}
