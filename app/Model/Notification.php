<?php
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
	* Send notification to a user, refering to revision $revision_id
	*/
	public function send($user_id,$revision_id,$message) {
	    $data = array('user_id'=>$user_id,
			  'revision_id'=>$revision_id,
			  'body_text'=>$message,
			  'active'=>true
			  );
	    $this->create();
	    $this->save($data);
	    #mail("grahamjones139@gmail.com","subject test","message text");
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

}
