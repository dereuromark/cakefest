<?php
namespace Test\TestCase\Model;

use Tools\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * Event Test Case
 *
 */
class EventsTableTest extends TestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = [
		'app.events',
		'app.attendees'
	];

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->Events = TableRegistry::get('Events');
	}

	/**
	 * EventsTest::testIsValidDate()
	 *
	 * @return void
	 */
	public function testIsValidDate() {
		$result = $this->Events->find();
		$this->assertSame(1, count($result));
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->Events);

		parent::tearDown();
	}

}
