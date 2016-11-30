<?php
namespace App\Controller;

use App\Controller\AppController;
use Tools\Utility\Time;

/**
 * @property \App\Model\Table\AttendeesTable $Attendees
 * @property \Cake\Controller\Component\PaginatorComponent $Paginator
 */
class AttendanceController extends AppController {

	/**
	 * @var string
	 */
	public $modelClass = 'Attendees';

	/**
	 * @return void
	 */
	public function index() {
		$query = $this->Attendees->find('upcoming')->where(['user_id' => $this->Session->read('Auth.User.id')]);

		$attendees = $this->paginate($query);
		$user = $this->Attendees->Users->get($this->Session->read('Auth.User.id'));
		$this->set(compact('attendees', 'user'));
	}

	/**
	 * @return \Cake\Network\Response|null
	 */
	public function add() {
		$events = $this->Attendees->Events->find('list', ['conditions' => ['Events.to >=' => new Time()]]);

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
				$defaults['from'] = $event['from']->format('Y-m-d') . ' ' . '08:00:00';
				$defaults['to'] = $event['to']->format('Y-m-d') . ' ' . '20:00:00';
			}
		}

		$this->request->data += $defaults;
		$attendee = $this->Attendees->newEntity();

		if ($this->Common->isPosted()) {
			$attendee = $this->Attendees->patchEntity($attendee, $this->request->data);

			if ($this->Attendees->save($attendee)) {
				$from = $attendee['from'];
				$to = $attendee['to'];
				$this->Flash->success(__('Attendance from {0} to {1} saved', $from, $to));
				return $this->Common->postRedirect(['action' => 'index']);
			}
			$this->Flash->error(__('formContainsErrors'));
		}
		$this->set(compact('attendee', 'events'));
	}

	/**
	 * @param string|null $id
	 * @return \Cake\Network\Response|null
	 */
	public function edit($id = null) {
		$uid = $this->Session->read('Auth.User.id');
		if (empty($id) || !($attendee = $this->Attendees->find('first', ['conditions' => ['Attendees.id' => $id, 'Attendees.user_id' => $uid]]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			$attendee = $this->Attendees->patchEntity($attendee, $this->request->data);
			if ($this->Attendees->save($attendee)) {
				$from = $attendee['from'];
				$to = $attendee['to'];
				$this->Flash->success(__('Attendance from {0} to {1} saved', $from, $to));
				return $this->Common->postRedirect(['action' => 'index']);
			}
			$this->Flash->error(__('formContainsErrors'));
		}
		$events = $this->Attendees->Events->find('list', ['conditions' => ['Events.to >=' => date('Y-m-d')]]);
		$this->set(compact('attendee', 'events'));
		$this->render('add');
	}

	/**
	 * @param string|null $id
	 * @return \Cake\Network\Response|null
	 */
	public function delete($id = null) {
		$this->request->allowMethod(['post', 'delete']);
		$uid = $this->Session->read('Auth.User.id');
		if (empty($id) || !($attendee = $this->Attendees->find('first', ['conditions' => ['Attendees.id' => $id, 'Attendees.user_id' => $uid], 'fields' => ['id', 'user_id']]))) {
			$this->Flash->error(__('invalidRecord'));
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$var = $attendee['user_id'];

		if ($this->Attendees->delete($attendee)) {
			$this->Flash->success(__('record del {0} done', h($var)));
			return $this->Common->postRedirect(['action' => 'index']);
		}
		$this->Flash->error(__('record del {0} not done exception', h($var)));
		return $this->Common->autoRedirect(['action' => 'index']);
	}

}
