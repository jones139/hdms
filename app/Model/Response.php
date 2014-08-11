<?php
App::uses('AppModel', 'Model');
/**
 * Response Model
 *
 * @package       app.Model
 * @property RouteListEntry $RouteListEntry
 */
class Response extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'RouteListEntry' => array(
			'className' => 'RouteListEntry',
			'foreignKey' => 'response_id',
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
