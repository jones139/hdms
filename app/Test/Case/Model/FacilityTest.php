<?php
App::uses('Facility', 'Model');

/**
 * Facility Test Case
 *
 */
class FacilityTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.facility',
		'app.doc',
		'app.revision',
		'app.user',
		'app.role',
		'app.notification',
		'app.route_list_entry',
		'app.route_list',
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
		$this->Facility = ClassRegistry::init('Facility');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Facility);

		parent::tearDown();
	}

}
