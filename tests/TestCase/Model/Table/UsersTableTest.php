<?php
namespace Test\TestCase\Model;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\TestCase;

/**
 * User Test Case
 */
class UsersTableTest extends TestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = [
		'app.users'
	];

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->Users = TableRegistry::get('Users');
	}

	/**
	 * EventsTest::testIsValidDate()
	 *
	 * @return void
	 */
	public function testIsValidDate() {
		$result = $this->Users->find();
		$this->assertSame(1, count($result));
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->Users);

		parent::tearDown();
	}

}
