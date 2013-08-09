<?php
App::uses('AppController', 'Controller');
/**
 * Overview Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class OverviewController extends AppController {

	public $uses = array('User');

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	/**
	 * OverviewController::beforeFilter()
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow();
	}

/**
 * Homepage.
 *
 * @return void
 */
	public function index() {
		$this->User->Attendee->recursive = 0;
		$this->set('attendees', $this->Paginator->paginate('Attendee'));
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
