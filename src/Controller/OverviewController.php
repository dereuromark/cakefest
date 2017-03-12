<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;

/**
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class OverviewController extends AppController {

	/**
	 * @var string
	 */
	public $modelClass = 'Users';

	/**
	 * @var array
	 */
	public $components = ['Paginator'];

	/**
	 * Homepage.
	 *
	 * @return void
	 */
	public function index() {
		// For now just the newest one
		//$event = $this->Users->Attendees->Events->find('first', array('order' => array('from' => 'DESC')));
		$event = $this->Users->Attendees->Events->find('all', ['order' => ['from' => 'DESC']])->first();
		if (!$event) {
			throw new NotFoundException('No event scheduled in admin area.');
		}

		$attendees = $this->Users->Attendees->find('all', ['conditions' => ['Attendees.event_id' => $event['id']]])
			->contain('Users');

		$this->set(compact('event', 'attendees'));
	}

	/**
	 * Admin backend.
	 *
	 * @return void
	 */
	public function admin() {
		//TODO
	}

}
