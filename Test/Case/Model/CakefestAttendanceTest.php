<?php
App::uses('CakefestAttendance', 'Model');

/**
 * CakefestAttendance Test Case
 *
 */
class CakefestAttendanceTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cakefest_attendance',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CakefestAttendance = ClassRegistry::init('CakefestAttendance');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CakefestAttendance);

		parent::tearDown();
	}

}
