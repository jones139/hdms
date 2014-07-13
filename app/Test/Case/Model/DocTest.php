<?php
App::uses('Doc', 'Model');

/**
 * Doc Test Case
 *
 */
class DocTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.doc',
		'app.revision'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Doc = ClassRegistry::init('Doc');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Doc);

		parent::tearDown();
	}

}
