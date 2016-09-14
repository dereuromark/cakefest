<?php
namespace Test\TestCase\Model;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

/**
 * User Test Case
 */
class UsersTableTest extends TestCase {

	/**
	 * @var \App\Model\Table\UsersTable
	 */
	protected $Users;

	/**
	 * @var array
	 */
	public $fixtures = [
		'app.users'
	];

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->Users = TableRegistry::get('Users');
	}

	/**
	 * @return void
	 */
	public function testIsValidDate() {
		$result = $this->Users->find()->all();
		$this->assertSame(1, count($result));
	}

	/**
	 * @return void
	 */
	public function tearDown() {
		unset($this->Users);

		parent::tearDown();
	}

}
