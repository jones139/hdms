<?php
/**
 * RouteListEntryFixture
 *
 */
class RouteListEntryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
		'route_list_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'response_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'response_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'response_comment' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 256, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
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
			'route_list_id' => 1,
			'user_id' => 1,
			'response_id' => 1,
			'response_date' => '2014-07-13 22:22:50',
			'response_comment' => 'Lorem ipsum dolor sit amet'
		),
	);

}
