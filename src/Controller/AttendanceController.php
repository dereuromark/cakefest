<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

/**
 * Attendance Controller
 *
 * @property Attendee $Attendee
 * @property PaginatorComponent $Paginator
 */
class AttendanceController extends AppController {

	public $modelClass = 'Attendees';

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$query = $this->Attendees->find('upcoming')->where(['user_id' => $this->Session->read('Auth.User.id')]);

		$attendees = $this->paginate($query);
		$user = $this->Attendees->Users->get($this->Session->read('Auth.User.id'));
		$this->set(compact('attendees', 'user'));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		$events = $this->Attendees->Events->find('list', array('conditions' => array('Events.to >=' => date(FORMAT_DB_DATETIME))));

		if ($this->Common->isPosted()) {
			$this->Attendees->create();
			$this->request->data['Attendee']['user_id'] = $this->Session->read('Auth.User.id');
			if ($this->Attendees->save($this->request->data)) {
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
				$event = $this->Attendees->Events->get(array_shift($key));
				$this->request->data['Attendee']['from'] = $event['from'] . ' ' . '08:00:00';
				$this->request->data['Attendee']['to'] = $event['to'] . ' ' . '20:00:00';
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
		if (empty($id) || !($attendee = $this->Attendees->find('first', array('conditions' => array('Attendees.id' => $id, 'Attendees.user_id' => $uid))))) {
			$this->Common->flashMessage(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			$this->Attendees->patchEntity($attendee, $this->request->data);
			if ($this->Attendees->save($attendee)) {
				$var = $this->request->data['user_id'];
				$this->Common->flashMessage(__('record edit %s saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			}
			$this->Common->flashMessage(__('formContainsErrors'), 'error');
		}
		$events = $this->Attendees->Events->find('list', array('conditions' => array('Events.to >=' => date(FORMAT_DB_DATETIME))));
		$this->set(compact('attendee', 'events'));
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
		if (empty($id) || !($attendee = $this->Attendees->find('first', array('conditions' => array('Attendees.id' => $id, 'Attendees.user_id' => $uid), 'fields' => array('id', 'user_id'))))) {
			$this->Common->flashMessage(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$var = $attendee['user_id'];

		if ($this->Attendees->delete($attendee)) {
			$this->Common->flashMessage(__('record del %s done', h($var)), 'success');
			return $this->Common->postRedirect(array('action' => 'index'));
		}
		$this->Common->flashMessage(__('record del %s not done exception', h($var)), 'error');
		return $this->Common->autoRedirect(array('action' => 'index'));
	}

}
