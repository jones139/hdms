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
		'app.user',
		'app.doc_status',
		'app.route_list_entry',
		'app.response'
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
