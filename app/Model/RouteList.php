<?php
App::uses('AppModel', 'Model');
/**
 * RouteList Model
 *
 * @property Revision $Revision
 * @property Revision $Revision
 * @property RouteListEntry $RouteListEntry
 */
class RouteList extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Revision' => array(
			'className' => 'Revision',
			'foreignKey' => 'revision_id',
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
		'Revision' => array(
			'className' => 'Revision',
			'foreignKey' => 'route_list_id',
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
			'foreignKey' => 'route_list_id',
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
