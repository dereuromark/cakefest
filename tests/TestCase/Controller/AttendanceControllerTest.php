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

		$data = array(
			'Auth' => array('User' => array('id' => 1, 'role_id' => 1))
		);
		$this->session($data);
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex()
	{
		$this->get(array('controller' => 'Attendance', 'action' => 'index'));
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
		$data = array(
			'from' => $from->addMonth(),
			'to' => $to->addMonth()->addWeek(),

		);
		$events = $Events->newEntity($data);
		$result = $Events->save($events);
		$this->assertTrue((bool)$result);

		$this->get(array('controller' => 'Attendance', 'action' => 'add'));
		$this->assertResponseCode(200);
		$this->assertNoRedirect();

		$this->assertSame(array(2 => ''), $this->_controller->viewVars['events']->toArray());
		$this->assertEquals($data['from']->format('Y-m-d'), $this->_controller->viewVars['attendee']->from->format('Y-m-d'));
		$this->assertEquals($data['to']->format('Y-m-d'), $this->_controller->viewVars['attendee']->to->format('Y-m-d'));
	}

	/**
	 * Test view method
	 *
	 * @return void
	 */
	public function testAddPost()
	{
		$data = array(
			'comment' => 'Foo bar'
		);
		$this->post(array('controller' => 'Attendance', 'action' => 'add'), $data);
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

		$data = array(
			'comment' => 'Foo bar'
		);
		$this->get(array('controller' => 'Attendance', 'action' => 'edit', $id));
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

		$data = array(
			'comment' => 'Foo bar'
		);
		$this->post(array('controller' => 'Attendance', 'action' => 'edit', $id), $data);
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

		$this->get(array('controller' => 'Attendance', 'action' => 'delete', $id));
		$this->assertResponseError(); // 405
		$this->assertFalse(true);
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

		$this->post(array('controller' => 'Attendance', 'action' => 'delete', $id));
		$this->assertResponseCode(302);
		$this->assertRedirect();
		$this->assertSession(array('record del 1 done'), 'FlashMessage.success');
	}
}
