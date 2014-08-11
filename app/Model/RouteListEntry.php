<?php
App::uses('AppModel', 'Model');
/**
 * RouteListEntry Model
 *
 * @package       app.Model
 * @property RouteList $RouteList
 * @property User $User
 * @property Response $Response
 */
class RouteListEntry extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'RouteList' => array(
			'className' => 'RouteList',
			'foreignKey' => 'route_list_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Response' => array(
			'className' => 'Response',
			'foreignKey' => 'response_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
