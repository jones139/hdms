<?php
App::uses('RouteList', 'Model');

/**
 * RouteList Test Case
 *
 */
class RouteListTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.route_list',
		'app.revision',
		'app.doc',
		'app.facility',
		'app.user',
		'app.role',
		'app.notification',
		'app.route_list_entry',
		'app.response',
		'app.doc_status'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->RouteList = ClassRegistry::init('RouteList');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->RouteList);

		parent::tearDown();
	}

}
