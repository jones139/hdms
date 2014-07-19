<?php
/**
 * RevisionFixture
 *
 */
class RevisionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
		'doc_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'major_revision' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'minor_revision' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'doc_status_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'has_native' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'has_pdf' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'has_extras' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'doc_id' => 1,
			'major_revision' => 1,
			'minor_revision' => 1,
			'user_id' => 1,
			'doc_status_id' => 1,
			'has_native' => 1,
			'has_pdf' => 1,
			'has_extras' => 1
		),
	);

}
