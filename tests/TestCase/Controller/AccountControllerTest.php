<?php

namespace App\Test\TestCase\Controller;

use App\Controller\AccountController;
use Tools\TestSuite\IntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\AccountController Test Case
 */
class AccountControllerTest extends IntegrationTestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = ['Users' => 'app.users', 'Attendees' => 'app.attendees', 'Events' => 'app.events'];

	public function setUp() {
		parent::setUp();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testLogin() {
		$this->get(array('controller' => 'Account', 'action' => 'login'));
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testLoginLoggedIn() {
		$data = array(
			'Auth' => array('User' => array('id' => 1, 'role_id' => 1))
		);
		$this->session($data);

		$this->get(array('controller' => 'Account', 'action' => 'login'));
		$this->assertResponseCode(200);
		$this->assertRedirect('/');
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testLoginPostInvalidData() {
		$this->post(array('controller' => 'Account', 'action' => 'login'));
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testLoginPostValidData() {
		$data = array(
			'username' => 'admin',
			'email' => 'admin@example.com',
			'pwd' => '123456'
		);
		$this->Users = TableRegistry::get('Users');
		$this->Users->addBehavior('Tools.Passwordable', array('confirm' => false));
		$user = $this->Users->newEntity($data);
		$result = $this->Users->save($user);
		$this->assertTrue((bool)$result);
		$this->Users->removeBehavior('Passwordable');

		$data = array(
			'login' => 'admin', 'password' => '123456'
		);
		$this->post(array('controller' => 'Account', 'action' => 'login'), $data);
		$this->assertResponseCode(200);
		$this->assertRedirect('/');
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testLoginPostValidDataEmail() {
		$data = array(
			'username' => 'admin',
			'email' => 'admin@example.com',
			'pwd' => '123456'
		);
		$this->Users = TableRegistry::get('Users');
		$this->Users->addBehavior('Tools.Passwordable', array('confirm' => false));
		$user = $this->Users->newEntity($data);
		$result = $this->Users->save($user);
		$this->assertTrue((bool)$result);
		$this->Users->removeBehavior('Passwordable');

		$data = array(
			'login' => 'admin@example.com', 'password' => '123456'
		);
		$this->post(array('controller' => 'Account', 'action' => 'login'), $data);
		$this->assertResponseCode(200);
		$this->assertRedirect('/');
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testLoginPostValidDataReferrer() {
		$session = array('Auth' => array('redirect' => '/attendance'));
		$this->session($session);

		$data = array(
			'username' => 'admin',
			'email' => 'admin@example.com',
			'pwd' => '123456'
		);
		$this->Users = TableRegistry::get('Users');
		$this->Users->addBehavior('Tools.Passwordable', array('confirm' => false));
		$user = $this->Users->newEntity($data);
		$result = $this->Users->save($user);
		$this->assertTrue((bool)$result);
		$this->Users->removeBehavior('Passwordable');

		$data = array(
			'login' => 'admin', 'password' => '123456'
		);
		$this->post(array('controller' => 'Account', 'action' => 'login'), $data);
		$this->assertResponseCode(200);
		$this->assertRedirect('/attendance');
	}

}
