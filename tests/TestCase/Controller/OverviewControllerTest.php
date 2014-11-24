<?php
namespace Test\TestCase\Controller;

use Tools\TestSuite\IntegrationTestCase;

/**
 * AttendeesController Test Case
 *
 */
class OverviewControllerTest extends IntegrationTestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array(
		'app.attendees',
		'app.events',
		'app.users'
	);

	/**
	 * testIndex method
	 *
	 * @return void
	 */
	public function testIndex() {
		$this->get(array('controller' => 'Overview', 'action' => 'index'));
		$this->assertResponseOk();
		//debug($this->_controller->viewVars);
	}

}
