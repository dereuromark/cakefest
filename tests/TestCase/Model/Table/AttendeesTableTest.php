<?php
namespace Test\TestCase\Model;

use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

/**
 * Attendee Test Case
 */
class AttendeesTableTest extends TestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'app.attendees',
		'app.events',
		'app.users',
	];

	/**
	 * @var \App\Model\Table\AttendeesTable
	 */
	public $Attendees;

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->Attendees = TableRegistry::get('Attendees');
	}

	/**
	 * @return void
	 */
	public function testIsValidDate() {
		$event = $this->Attendees->Events->newEntity(['from' => new Time('2014-04-12'), 'to' => new Time('2014-04-20')]);
		$result = $this->Attendees->Events->save($event);
		$this->assertTrue((bool)$result);

		$context = [
			'data' => [
				'event_id' => $event->id,
			]
		];
		$result = $this->Attendees->isValidDate(new Time('2014-04-04'), 'from', $context);
		$this->assertTrue($result);

		$result = $this->Attendees->isValidDate(new Time('2014-04-01'), 'from', $context);
		$this->assertTrue($result !== true);

		$result = $this->Attendees->isValidDate(new Time('2014-04-22'), 'to', $context);
		$this->assertTrue($result);

		$result = $this->Attendees->isValidDate(new Time('2014-05-01'), 'to', $context);
		$this->assertTrue($result !== true);
	}

	/**
	 * @return void
	 */
	public function tearDown() {
		unset($this->Attendees);

		parent::tearDown();
	}

}
