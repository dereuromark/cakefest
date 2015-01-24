<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Tools\Utility\Time;

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

		$defaults = [
			'from' => new Time(),
			'to' => new Time(),
			'user_id' => $this->Session->read('Auth.User.id')
		];
		if (!$this->Common->isPosted()) {
			$eventList = $events->toArray();
			if (count($eventList) === 1) {
				$key = array_keys($eventList);
				$key = array_shift($key);

				$event = $this->Attendees->Events->get($key);
				$defaults['from'] = $event['from']->format(FORMAT_DB_DATE) . ' ' . '08:00:00';
				$defaults['to'] = $event['to']->format(FORMAT_DB_DATE) . ' ' . '20:00:00';
			}
		}
		$this->request->data += $defaults;
		$attendee = $this->Attendees->newEntity($this->request->data);

		if ($this->Common->isPosted()) {
			if ($this->Attendees->save($attendee)) {
				$from = $attendee['from'];
				$to = $attendee['to'];
				$this->Flash->message(__('Attendance from {0} to {1} saved', $from, $to), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			}
			$this->Flash->message(__('formContainsErrors'), 'error');
		}
		$this->set(compact('attendee', 'events'));
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
			$this->Flash->message(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			$this->Attendees->patchEntity($attendee, $this->request->data);
			if ($this->Attendees->save($attendee)) {
				$from = $attendee['from'];
				$to = $attendee['to'];
				$this->Flash->message(__('Attendance from {0} to {1} saved', $from, $to), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			}
			$this->Flash->message(__('formContainsErrors'), 'error');
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
		$this->request->allowMethod(['post', 'delete']);
		$uid = $this->Session->read('Auth.User.id');
		if (empty($id) || !($attendee = $this->Attendees->find('first', array('conditions' => array('Attendees.id' => $id, 'Attendees.user_id' => $uid), 'fields' => array('id', 'user_id'))))) {
			$this->Flash->message(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$var = $attendee['user_id'];

		if ($this->Attendees->delete($attendee)) {
			$this->Flash->message(__('record del {0} done', h($var)), 'success');
			return $this->Common->postRedirect(array('action' => 'index'));
		}
		$this->Flash->message(__('record del {0} not done exception', h($var)), 'error');
		return $this->Common->autoRedirect(array('action' => 'index'));
	}

}
