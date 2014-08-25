<?php
App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');/**
 * User Model
 *
 * @package       app.Model
 * @property Role $Role
 * @property Notification $Notification
 * @property Revision $Revision
 * @property RouteListEntry $RouteListEntry
 */
class User extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Role' => array(
			'className' => 'Role',
			'foreignKey' => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Notification' => array(
			'className' => 'Notification',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Revision' => array(
			'className' => 'Revision',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'RouteListEntry' => array(
			'className' => 'RouteListEntry',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public $validate = array(
	       'password' => array(
    	       	     'length' => array(
        	     	      'rule'      => array('between', 4, 40),
			      'allowEmpty'  => true,
        		      'message'   => 'Your password must be between 4 and 40 characters.',
    			      ),
		),
		'confirm_password' => array(
    		     'length' => array(
        	     	      'rule'      => array('between', 4, 40),
			      'allowEmpty'  => true,
        	     	      'message'   => 'Your password must be between 4 and 40 characters.',
    		     ),
    		'compare'    => array(
        		     'rule'      => array('validate_passwords'),
        		     'message' => 'The passwords you entered do not match.',
    			     )
		)
	);

	/**
	* Confirm that both provided passwords are the same
	*/
	public function validate_passwords() {
    	       return $this->data[$this->alias]['password'] === 
	              $this->data[$this->alias]['confirm_password'];
	}

	public function beforeSave($options = array()) {
    	       if (isset($this->data[$this->alias]['password'])) {
               	  $passwordHasher = new SimplePasswordHasher();
        	  $this->data[$this->alias]['password'] = $passwordHasher->hash(
        			$this->data[$this->alias]['password']
        						);
    		}
    		return true;
	}


	/** Do not change the user's password if they have not provided
	 * a password.
	 * (taken from http://bakery.cakephp.org/articles/rajender120/2011/08/19/password_validation_in_cakephp)
	 * FIXME - how do we tell the user the password has not been changed??
	 */
	public function beforeValidate($options=Array()) {
	   if(empty($this->data['User']['confirm_password'])) {
	   	unset($this->data['User']['password']);
	   }
	   return true;
	}

	/**
	* Returns true if user.id is an administrator, otherwise
	*  returns fase.
	* @param id - user id.
	*/
	public function isAdmin($id = null) {
		# Populate $this->data with data from user.id=$id
		$this->read(null, $id);
		if ($this.role_id == 1)
		   return true;
		else
		   return false;
	}

}
