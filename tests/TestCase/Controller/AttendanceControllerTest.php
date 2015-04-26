<?php
namespace App\Test\TestCase\Controller;

use App\Controller\AttendanceController;
use Tools\TestSuite\IntegrationTestCase;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

/**
 * App\Controller\Attendance Test Case
 */
class AttendanceControllerTest extends IntegrationTestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = [
		'Users' => 'app.users',
		'Attendees' => 'app.attendees',
		'Events' => 'app.events'
	];

	public function setUp() {
		parent::setUp();

		$data = [
			'Auth' => ['User' => ['id' => 1, 'role_id' => 1]]
		];
		$this->session($data);
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex()
	{
		$this->get(['controller' => 'Attendance', 'action' => 'index']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test view method
	 *
	 * @return void
	 */
	public function testAdd()
	{
		$Events = TableRegistry::get('Events');
		$from = new Time();
		$to = new Time();
		$data = [
			'from' => $from->addMonth(),
			'to' => $to->addMonth()->addWeek(),

		];
		$events = $Events->newEntity($data);
		$result = $Events->save($events);
		$this->assertTrue((bool)$result);

		$this->get(['controller' => 'Attendance', 'action' => 'add']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();

		$from = new Time($this->_controller->request->data['from']);
		$to = new Time($this->_controller->request->data['to']);
		$this->assertSame([2 => ''], $this->_controller->viewVars['events']->toArray());
		$this->assertEquals($data['from']->format('Y-m-d'), $from->format('Y-m-d'));
		$this->assertEquals($data['to']->format('Y-m-d'), $to->format('Y-m-d'));
	}

	/**
	 * Test view method
	 *
	 * @return void
	 */
	public function testAddPost()
	{
		$data = [
			'comment' => 'Foo bar'
		];
		$this->post(['controller' => 'Attendance', 'action' => 'add'], $data);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();

		$this->assertResponseContains('<div class="message error">');
	}

	/**
	 * Test edit method
	 *
	 * @return void
	 */
	public function testEdit()
	{
		$Attendees = TableRegistry::get('Attendees');
		$record = $Attendees->find()->first();
		$id = $record->id;

		$data = [
			'comment' => 'Foo bar'
		];
		$this->get(['controller' => 'Attendance', 'action' => 'edit', $id]);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test edit method
	 *
	 * @return void
	 */
	public function testEditPost()
	{
		$Attendees = TableRegistry::get('Attendees');
		$record = $Attendees->find()->first();
		$id = $record->id;

		$data = [
			'comment' => 'Foo bar'
		];
		$this->post(['controller' => 'Attendance', 'action' => 'edit', $id], $data);
		$this->assertResponseCode(302);
		$this->assertRedirect();

		$record = $Attendees->find()->first();
		$this->assertSame('Foo bar', $record->comment);
	}

	/**
	 * Test delete method
	 *
	 * @return void
	 */
	public function testDeleteInvalid()
	{
		$Attendees = TableRegistry::get('Attendees');
		$record = $Attendees->find()->first();
		$id = $record->id;

		$this->get(['controller' => 'Attendance', 'action' => 'delete', $id]);
		$this->assertResponseError(); // 405
	}

	/**
	 * Test delete method
	 *
	 * @return void
	 */
	public function testDeletePost()
	{
		$Attendees = TableRegistry::get('Attendees');
		$record = $Attendees->find()->first();
		$id = $record->id;

		$this->post(['controller' => 'Attendance', 'action' => 'delete', $id]);
		$this->assertResponseCode(302);
		$this->assertRedirect();
		$this->assertSession(['record del 1 done'], 'FlashMessage.success');
	}
}
