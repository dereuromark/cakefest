<?php
namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Tools\TestSuite\IntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\UsersController Test Case
 */
class UsersControllerTest extends IntegrationTestCase {

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
		$this->get(array('controller' => 'Users', 'action' => 'index'));
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test view method
	 *
	 * @return void
	 */
	public function testViewInvalid()
	{
		$id = 999;

		$this->get(array('controller' => 'Users', 'action' => 'view', $id));
		$this->assertResponseCode(404);
		$this->assertNoRedirect();
	}

	/**
	 * Test view method
	 *
	 * @return void
	 */
	public function testView()
	{
		$Users = TableRegistry::get('Users');
		$record = $Users->find()->first();
		$id = $record->id;

		$this->get(array('controller' => 'Users', 'action' => 'view', $id));
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test edit method
	 *
	 * @return void
	 */
	public function testEdit()
	{
		$Users = TableRegistry::get('Users');
		$record = $Users->find()->first();
		$id = $record->id;

		$this->get(array('controller' => 'Users', 'action' => 'view', $id));
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test delete method
	 *
	 * @return void
	 */
	public function testDelete()
	{
		$Users = TableRegistry::get('Users');
		$record = $Users->find()->first();
		$id = $record->id;

		$this->post(array('controller' => 'Users', 'action' => 'delete', $id));
		$this->assertResponseCode(302);
		$this->assertRedirect();
	}
}
