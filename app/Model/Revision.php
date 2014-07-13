<?php
App::uses('AppModel', 'Model');
/**
 * Revision Model
 *
 * @property Doc $Doc
 * @property User $User
 * @property DocStatus $DocStatus
 * @property RouteList $RouteList
 * @property RouteList $RouteList
 */
class Revision extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Doc' => array(
			'className' => 'Doc',
			'foreignKey' => 'doc_id',
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
		'DocStatus' => array(
			'className' => 'DocStatus',
			'foreignKey' => 'doc_status_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'RouteList' => array(
			'className' => 'RouteList',
			'foreignKey' => 'route_list_id',
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
		'RouteList' => array(
			'className' => 'RouteList',
			'foreignKey' => 'revision_id',
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

}
