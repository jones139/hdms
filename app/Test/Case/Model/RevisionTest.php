<?php
App::uses('Revision', 'Model');

/**
 * Revision Test Case
 *
 */
class RevisionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.revision',
		'app.doc',
		'app.facility',
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
		$this->Revision = ClassRegistry::init('Revision');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Revision);

		parent::tearDown();
	}

}
