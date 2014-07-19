<?php
App::uses('Role', 'Model');

/**
 * Role Test Case
 *
 */
class RoleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.role',
		'app.user',
		'app.notification',
		'app.revision',
		'app.doc',
		'app.facility',
		'app.doc_status',
		'app.route_list',
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
		$this->Role = ClassRegistry::init('Role');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Role);

		parent::tearDown();
	}

}
