<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Attendance Controller
 *
 * @property Attendee $Attendee
 * @property PaginatorComponent $Paginator
 */
class AttendanceController extends AppController {

	public $modelClass = 'Attendee';

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->Attendee->recursive = 0;

		$this->paginate['conditions']['user_id'] = $this->Session->read('Auth.User.id');
		$this->paginate['conditions']['Event.to >='] = date(FORMAT_DB_DATETIME);

		$attendees = $this->paginate();
		$user = $this->Attendee->User->get($this->Session->read('Auth.User.id'));
		$this->set(compact('attendees', 'user'));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		$events = $this->Attendee->Event->find('list', array('conditions' => array('Event.to >=' => date(FORMAT_DB_DATETIME))));

		if ($this->Common->isPosted()) {
			$this->Attendee->create();
			$this->request->data['Attendee']['user_id'] = $this->Session->read('Auth.User.id');
			if ($this->Attendee->save($this->request->data)) {
				$var = $this->request->data['Attendee']['user_id'];
				$this->Common->flashMessage(__('record add %s saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			}
			$this->Common->flashMessage(__('formContainsErrors'), 'error');
		} else {
			$this->request->data['Attendee']['from'] = date(FORMAT_DB_DATETIME);
			$this->request->data['Attendee']['to'] = date(FORMAT_DB_DATETIME);

			if (count($events) === 1) {
				$key = array_keys($events);
				$event = $this->Attendee->Event->get(array_shift($key));
				$this->request->data['Attendee']['from'] = $event['Event']['from'] . ' ' . '08:00:00';
				$this->request->data['Attendee']['to'] = $event['Event']['to'] . ' ' . '20:00:00';
			}
		}

		$this->set(compact('events'));
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
		$events = $this->Attendee->Event->find('list', array('conditions' => array('Event.to >=' => date(FORMAT_DB_DATETIME))));
		$this->set(compact('events'));
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
		$this->request->allowMethod('post', 'delete');
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
