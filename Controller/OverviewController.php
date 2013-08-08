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
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->CakefestAttendance->recursive = 0;
		$this->set('cakefestAttendance', $this->Paginator->paginate('CakefestAttendance'));
	}

}
