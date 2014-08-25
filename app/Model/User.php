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

	public function beforeSave($options = array()) {
    	       if (isset($this->data[$this->alias]['password'])) {
               	  $passwordHasher = new SimplePasswordHasher();
        	  $this->data[$this->alias]['password'] = $passwordHasher->hash(
        			$this->data[$this->alias]['password']
        						);
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
