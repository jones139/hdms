<?php
App::uses('DocSubtype', 'Model');

/**
 * DocSubtype Test Case
 *
 */
class DocSubtypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.doc_subtype',
		'app.doc',
		'app.facility',
		'app.doc_type',
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
		$this->DocSubtype = ClassRegistry::init('DocSubtype');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DocSubtype);

		parent::tearDown();
	}

}
