<?php
namespace App\Controller;

use Cake\Event\Event;
use App\Controller\AppController;

/**
 * Overview Controller
 *
 */
class OverviewController extends AppController {

	public $modelClass = 'Users';

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = ['Paginator'];

	/**
	 * OverviewController::beforeFilter()
	 *
	 * @return void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow('index');
	}

	/**
	 * Homepage.
	 *
	 * @return void
	 */
	public function index() {
		// For now just the newest one
		//$event = $this->Users->Attendees->Events->find('first', array('order' => array('from' => 'DESC')));
		$event = $this->Users->Attendees->Events->find('all', ['order' => ['from' => 'DESC']])->first();

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
