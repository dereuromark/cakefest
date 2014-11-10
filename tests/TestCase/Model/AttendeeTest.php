<?php
namespace Test\TestCase\Model;
use App\Model\Attendee;

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
		'app.attendees',
		'app.events',
		'app.users',
		'app.cakefest_attendances'
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
