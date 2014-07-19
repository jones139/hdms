<?php
/**
 * DocFixture
 *
 */
class DocFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
		'facility_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'docType' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'docNo' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 256, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
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
			'facility_id' => 1,
			'docType' => 1,
			'docNo' => 'Lorem ipsum dolor sit amet',
			'title' => 'Lorem ipsum dolor sit amet'
		),
	);

}
