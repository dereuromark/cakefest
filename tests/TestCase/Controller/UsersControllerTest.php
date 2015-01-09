<?php
namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Tools\TestSuite\IntegrationTestCase;

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
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
