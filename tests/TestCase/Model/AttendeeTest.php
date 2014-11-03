<?php
App::uses('Attendee', 'Model');

/**
 * Attendee Test Case
 *
 */
class AttendeeTest extends CakeTestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array(
		'app.attendee',
		'app.event',
		'app.user',
		'app.cakefest_attendance'
	);

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->Attendee = ClassRegistry::init('Attendee');
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->Attendee);

		parent::tearDown();
	}

}
