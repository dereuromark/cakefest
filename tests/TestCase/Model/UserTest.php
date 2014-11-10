<?php
namespace Test\TestCase\Model;
use App\Model\User;

/**
 * User Test Case
 *
 */
class UserTest extends TestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array(
		'app.users',
		'app.roles',
		'app.languages'
	);

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->User = ClassRegistry::init('User');
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->User);

		parent::tearDown();
	}

}
