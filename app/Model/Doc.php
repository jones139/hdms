<?php
App::uses('AppModel', 'Model');
/**
 * Doc Model
 *
 * @property Facility $Facility
 * @property Revision $Revision
 */
class Doc extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Facility' => array(
			'className' => 'Facility',
			'foreignKey' => 'facility_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'DocType' => array(
			'className' => 'DocType',
			'foreignKey' => 'doc_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'DocSubtype' => array(
			'className' => 'DocSubtype',
			'foreignKey' => 'doc_subtype_id',
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
