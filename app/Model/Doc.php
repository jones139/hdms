<?php
App::uses('AppModel', 'Model');
/**
 * Doc Model
 *
 * @property Revision $Revision
 */
class Doc extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Revision' => array(
			'className' => 'Revision',
			'foreignKey' => 'doc_id',
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
