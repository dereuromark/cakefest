<?php
App::uses('AppController', 'Controller');

/**
 * Attendance Controller
 *
 * @property Attendee $Attendee
 * @property PaginatorComponent $Paginator
 */
class AttendanceController extends AppController {

	public $uses = array('Attendee');

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
		$this->Attendee->recursive = 0;

		$this->Paginator->settings['conditions']['user_id'] = $this->Session->read('Auth.User.id');

		$attendees = $this->Paginator->paginate();
		$user = $this->Attendee->User->get($this->Session->read('Auth.User.id'));
		$this->set(compact('attendees', 'user'));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this->Common->isPosted()) {
			$this->Attendee->create();
			$this->request->data['Attendee']['user_id'] = $this->Session->read('Auth.User.id');
			if ($this->Attendee->save($this->request->data)) {
				$var = $this->request->data['Attendee']['user_id'];
				$this->Common->flashMessage(__('record add %s saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			}
			$this->Common->flashMessage(__('formContainsErrors'), 'error');
		}

		$events = $this->Attendee->Event->find('list');
		$users = $this->Attendee->User->find('list');
		$this->set(compact('events', 'users'));
	}

	/**
	 * edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		$uid = $this->Session->read('Auth.User.id');
		if (empty($id) || !($attendee = $this->Attendee->find('first', array('conditions' => array('Attendee.id' => $id, 'Attendee.user_id' => $uid))))) {
			$this->Common->flashMessage(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			$this->request->data['Attendee']['id'] = $attendee['Attendee']['id'];
			if ($this->Attendee->save($this->request->data)) {
				$var = $this->request->data['Attendee']['user_id'];
				$this->Common->flashMessage(__('record edit %s saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			}
			$this->Common->flashMessage(__('formContainsErrors'), 'error');
		} else {
			$this->request->data = $attendee;
		}
		$events = $this->Attendee->Event->find('list');
		$users = $this->Attendee->User->find('list');
		$this->set(compact('events', 'users'));
		$this->render('add');
	}

	/**
	 * delete method
	 *
	 * @throws MethodNotAllowedException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		$this->request->onlyAllow('post', 'delete');
		$uid = $this->Session->read('Auth.User.id');
		if (empty($id) || !($attendee = $this->Attendee->find('first', array('conditions' => array('Attendee.id' => $id, 'Attendee.user_id' => $uid), 'fields' => array('id', 'user_id'))))) {
			$this->Common->flashMessage(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$var = $attendee['Attendee']['user_id'];

		if ($this->Attendee->delete($id)) {
			$this->Common->flashMessage(__('record del %s done', h($var)), 'success');
			return $this->Common->postRedirect(array('action' => 'index'));
		}
		$this->Common->flashMessage(__('record del %s not done exception', h($var)), 'error');
		return $this->Common->autoRedirect(array('action' => 'index'));
	}

}
