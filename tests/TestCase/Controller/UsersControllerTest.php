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

		$data = [
			'Auth' => ['User' => ['id' => 1, 'role_id' => 1]]
		];
		$this->session($data);
	}

	public function tearDown() {
		parent::tearDown();

		TableRegistry::clear();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex() {
		$this->get(['controller' => 'Users', 'action' => 'index']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test view method
	 *
	 * @return void
	 */
	public function testViewInvalid() {
		$id = 999;

		$this->get(['controller' => 'Users', 'action' => 'view', $id]);
		$this->assertResponseCode(404);
		$this->assertNoRedirect();
	}

	/**
	 * Test view method
	 *
	 * @return void
	 */
	public function testView() {
		$Users = TableRegistry::get('Users');
		$record = $Users->find()->first();
		$id = $record->id;

		$this->get(['controller' => 'Users', 'action' => 'view', $id]);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test edit method
	 *
	 * @return void
	 */
	public function testEdit() {
		$Users = TableRegistry::get('Users');
		$record = $Users->find()->first();
		$id = $record->id;

		$this->get(['controller' => 'Users', 'action' => 'edit', $id]);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test delete method
	 *
	 * @return void
	 */
	public function testDelete() {
		$Users = TableRegistry::get('Users');
		$record = $Users->find()->first();
		$id = $record->id;

		$this->post(['controller' => 'Users', 'action' => 'delete', $id]);
		$this->assertResponseCode(302);
		$this->assertRedirect();
	}
}
