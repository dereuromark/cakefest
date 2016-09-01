<?php
namespace Test\TestCase\Model;

use App\Model\Entity\User;
use Tools\TestSuite\TestCase;

/**
 * User Test Case
 */
class UserTest extends TestCase {

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
	}

	/**
	 * EventsTest::testIsValidDate()
	 *
	 * @return void
	 */
	public function testStatuses() {
		$result = User::statuses();
		$this->assertSame(2, count($result));

		$result = User::statuses(User::STATUS_CORE_DEV);
		$this->assertEquals(__('CakePHP Core Developer'), $result);
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
