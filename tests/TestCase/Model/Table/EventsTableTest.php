<?php
namespace Test\TestCase\Model;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

/**
 * Event Test Case
 */
class EventsTableTest extends TestCase {

	/**
	 * @var \App\Model\Table\EventsTable
	 */
	public $Events;

	/**
	 * @var array
	 */
	public $fixtures = [
		'app.events',
		'app.attendees'
	];

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->Events = TableRegistry::get('Events');
	}

	/**
	 * @return void
	 */
	public function testIsValidDate() {
		$result = $this->Events->find()->all();
		$this->assertSame(1, count($result));
	}

	/**
	 * @return void
	 */
	public function tearDown() {
		unset($this->Events);

		parent::tearDown();
	}

}
