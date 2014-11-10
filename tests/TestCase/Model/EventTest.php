<?php
namespace Test\TestCase\Model;
use App\Model\Event;

/**
 * Event Test Case
 *
 */
class EventTest extends CakeTestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array(
		'app.events',
		'app.attendees'
	);

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->Event = ClassRegistry::init('Event');
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->Event);

		parent::tearDown();
	}

}
