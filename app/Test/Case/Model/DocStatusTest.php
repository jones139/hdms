<?php
App::uses('DocStatus', 'Model');

/**
 * DocStatus Test Case
 *
 */
class DocStatusTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.doc_status',
		'app.revision',
		'app.doc',
		'app.facility',
		'app.user',
		'app.role',
		'app.notification',
		'app.route_list_entry',
		'app.route_list',
		'app.response'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->DocStatus = ClassRegistry::init('DocStatus');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DocStatus);

		parent::tearDown();
	}

}
