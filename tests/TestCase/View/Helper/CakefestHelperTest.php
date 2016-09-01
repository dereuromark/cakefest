<?php
namespace Tools\TestCase\View\Helper;

use App\View\Helper\CakefestHelper;
use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * Cakefest Helper Test Case
 */
class CakefestHelperTest extends TestCase {

	/**
	 * @var \App\View\Helper\CakefestHelper
	 */
	public $Cakefest;

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->Cakefest = new CakefestHelper(new View(null));
	}

	/**
	 * @return void
	 */
	public function testRoleName() {
		$result = $this->Cakefest->roleName(Configure::read('Roles.admin'));
		$this->assertEquals('admin', $result);
	}

	public function tearDown() {
		parent::tearDown();

		unset($this->Cakefest);
	}

}
