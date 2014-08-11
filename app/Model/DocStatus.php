<?php
App::uses('AppModel', 'Model');
/**
 * DocStatus Model
 *
 * @package       app.Model
 * @property Revision $Revision
 */
class DocStatus extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Revision' => array(
			'className' => 'Revision',
			'foreignKey' => 'doc_status_id',
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
