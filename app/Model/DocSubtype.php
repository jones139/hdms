<?php
App::uses('AppModel', 'Model');
/**
 * DocSubtype Model
 *
 * @package       app.Model
 * @property Doc $Doc
 */
class DocSubtype extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Doc' => array(
			'className' => 'Doc',
			'foreignKey' => 'doc_subtype_id',
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
