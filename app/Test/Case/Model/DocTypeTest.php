<?php
App::uses('DocType', 'Model');

/**
 * DocType Test Case
 *
 */
class DocTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.doc_type',
		'app.doc',
		'app.facility',
		'app.doc_subtype',
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
		$this->DocType = ClassRegistry::init('DocType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DocType);

		parent::tearDown();
	}

}
