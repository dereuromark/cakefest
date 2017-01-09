<?php

namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

/**
 * App\Controller\AccountController Test Case
 */
class AccountControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'Users' => 'app.users', 'Attendees' => 'app.attendees', 'Events' => 'app.events',
		'plugin.Tools.tokens'];

	public function setUp() {
		parent::setUp();
	}

	public function tearDown() {
		parent::tearDown();

		TableRegistry::clear();
	}

	/**
	 * @return void
	 */
	public function testLogin() {
		$this->get(['controller' => 'Account', 'action' => 'login']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testLoginLoggedIn() {
		$data = [
			'Auth' => ['User' => ['id' => 1, 'role_id' => 1]]
		];
		$this->session($data);

		$this->get(['controller' => 'Account', 'action' => 'login']);
		$this->assertResponseCode(302);
		$this->assertRedirect('/');
	}

	/**
	 * @return void
	 */
	public function testLoginPostInvalidData() {
		$this->post(['controller' => 'Account', 'action' => 'login']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testLoginPostValidData() {
		$data = [
			'username' => 'admin',
			'email' => 'admin@example.com',
			'pwd' => '123456'
		];
		$this->Users = TableRegistry::get('Users');
		$this->Users->addBehavior('Tools.Passwordable', ['confirm' => false]);
		$user = $this->Users->newEntity($data);
		$result = $this->Users->save($user);
		$this->assertTrue((bool)$result);
		$this->Users->removeBehavior('Passwordable');

		$data = [
			'login' => 'admin', 'password' => '123456'
		];
		$this->post(['controller' => 'Account', 'action' => 'login'], $data);
		$this->assertResponseCode(302);
		$this->assertRedirect('/');
	}

	/**
	 * @return void
	 */
	public function testLoginPostValidDataEmail() {
		$data = [
			'username' => 'admin',
			'email' => 'admin@example.com',
			'pwd' => '123456'
		];
		$this->Users = TableRegistry::get('Users');
		$this->Users->addBehavior('Tools.Passwordable', ['confirm' => false]);
		$user = $this->Users->newEntity($data);
		$result = $this->Users->save($user);
		$this->assertTrue((bool)$result);
		$this->Users->removeBehavior('Passwordable');

		$data = [
			'login' => 'admin@example.com', 'password' => '123456'
		];
		$this->post(['controller' => 'Account', 'action' => 'login'], $data);
		$this->assertResponseCode(302);
		$this->assertRedirect('/');
	}

	/**
	 * @return void
	 */
	public function testLoginPostValidDataReferrer() {
		$this->skipIf(true, '//FIXME for 3.4 query strings');

		$data = [
			'username' => 'admin',
			'email' => 'admin@example.com',
			'pwd' => '123456'
		];
		$this->Users = TableRegistry::get('Users');
		$this->Users->addBehavior('Tools.Passwordable', ['confirm' => false]);
		$user = $this->Users->newEntity($data);
		$result = $this->Users->save($user);
		$this->assertTrue((bool)$result);
		$this->Users->removeBehavior('Passwordable');

		$data = [
			'login' => 'admin', 'password' => '123456'
		];
		$this->post(['controller' => 'Account', 'action' => 'login'], $data);
		$this->assertResponseCode(302);
		$this->assertRedirect('/attendance');
	}

	/**
	 * @return void
	 */
	public function testLogout() {
		$session = ['Auth' => ['User' => ['id' => '1']]];
		$this->session($session);

		$this->get(['controller' => 'Account', 'action' => 'logout']);
		$this->assertResponseCode(302);
		$this->assertRedirect('/');
	}

	/**
	 * @return void
	 */
	public function testLostPassword() {
		$this->get(['controller' => 'Account', 'action' => 'lost_password']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testLostPasswordPost() {
		$data = [
			'Form' => [
				'login' => 'foo@bar.de',
			]
		];
		$this->post(['controller' => 'Account', 'action' => 'lost_password'], $data);
		$this->assertResponseCode(302);
		$this->assertRedirect();
	}

	/**
	 * @return void
	 */
	public function testChangePasswordInvalid() {
		$this->get(['controller' => 'Account', 'action' => 'change_password']);
		$this->assertResponseCode(302);
		$this->assertRedirect(['controller' => 'Account', 'action' => 'lost_password']);
	}

	/**
	 * @return void
	 */
	public function testChangePassword() {
		$session = ['Auth' => ['Tmp' => ['id' => '1']]];
		$this->session($session);

		$this->get(['controller' => 'Account', 'action' => 'change_password']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testChangePasswordPost() {
		$this->Users = TableRegistry::get('Users');
		$username = $this->Users->field('username');

		$session = ['Auth' => ['Tmp' => ['id' => '1']]];
		$this->session($session);

		$data = [
			'pwd' => '123456',
			'pwd_repeat' => '123456'
		];
		$this->post(['controller' => 'Account', 'action' => 'change_password'], $data);
		$this->assertResponseCode(302);
		$this->assertRedirect(['action' => 'login', '?' => ['username' => $username]]);

		$this->assertSession(__('new pw saved - you may now log in'), 'Flash.flash.0.message');
	}

	/**
	 * @return void
	 */
	public function testRegister() {
		$this->get(['controller' => 'Account', 'action' => 'register']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testRegisterPostInvalid() {
		$data = [
			'username' => '',
			'email' => ''
		];

		$this->post(['controller' => 'Account', 'action' => 'register'], $data);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testRegisterPost() {
		$data = [
			'username' => 'fooobar',
			'email' => 'foobar@example.com',
			'pwd' => '123456',
			'pwd_repeat' => '123456',
		];

		$this->post(['controller' => 'Account', 'action' => 'register'], $data);
		$this->assertResponseCode(302);
		$this->assertRedirect();
	}

	/**
	 * @return void
	 */
	public function testEdit() {
		$Users = TableRegistry::get('Users');
		$record = $Users->find()->first();
		$id = $record->id;

		$session = ['Auth' => ['User' => ['id' => $id, 'role_id' => 1]]];
		$this->session($session);

		$this->get(['controller' => 'Account', 'action' => 'edit']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testEditPost() {
		$Users = TableRegistry::get('Users');
		$record = $Users->find()->first();
		$id = $record->id;

		$session = ['Auth' => ['User' => ['id' => $id, 'role_id' => 1]]];
		$this->session($session);

		$this->post(['controller' => 'Account', 'action' => 'edit']);
		$this->assertResponseCode(302);
		$this->assertRedirect();
	}

	/**
	 * @return void
	 */
	public function testDelete() {
		$Users = TableRegistry::get('Users');
		$record = $Users->find()->first();
		$id = $record->id;

		$session = ['Auth' => ['User' => ['id' => $id, 'role_id' => 1]]];
		$this->session($session);

		$this->post(['controller' => 'Account', 'action' => 'delete']);
		$this->assertResponseCode(302);
		$this->assertRedirect();

		$record = $Users->find()->where(['id' => $id])->first();
		$this->assertEmpty($record);
	}

}
