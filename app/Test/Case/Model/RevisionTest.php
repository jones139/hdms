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
		'app.user',
		'app.doc_status',
		'app.route_list'
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
