<?php
App::uses('RouteListEntry', 'Model');

/**
 * RouteListEntry Test Case
 *
 */
class RouteListEntryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.route_list_entry',
		'app.route_list',
		'app.user',
		'app.response'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->RouteListEntry = ClassRegistry::init('RouteListEntry');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->RouteListEntry);

		parent::tearDown();
	}

}
