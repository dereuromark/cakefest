<?php
namespace App\Controller;

use Cake\Event\Event;
use App\Controller\AppController;
use Tools\Mailer\Email;
use Cake\Core\Configure;

/**
 * Attendees Controller
 *
 * @property Attendee $Attendee
 */
class AttendeesController extends AppController {

	/**
	 * AttendeesController::beforeFilter()
	 *
	 * @return void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow('view');
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->paginate['contain'] = ['Events', 'Users'];

		$attendees = $this->paginate();
		$this->set(compact('attendees'));
	}

	/**
	 * AttendeesController::map()
	 *
	 * @return void
	 */
	public function map() {

	}

	/**
	 * view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		if (empty($id) || !($attendee = $this->Attendees->get($id, ['contain' => ['Events', 'Users']]))) {
			$this->Flash->message(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$this->set(compact('attendee'));
	}

	/**
	 * edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		if (empty($id) || !($attendee = $this->Attendees->find('first', ['conditions' => ['Attendees.id' => $id]]))) {
			$this->Flash->message(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			$this->Attendees->patchEntity($attendee, $this->request->data);
			if ($this->Attendees->save($attendee)) {
				$var = $this->request->data['user_id'];
				$this->Flash->message(__('record edit {0} saved', h($var)), 'success');
				return $this->Common->postRedirect(['action' => 'index']);
			}
			$this->Flash->message(__('formContainsErrors'), 'error');
		}

		$events = $this->Attendees->Events->find('list');
		$users = $this->Attendees->Users->find('list');
		$this->set(compact('attendee', 'events', 'users'));
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
		if (empty($id) || !($attendee = $this->Attendees->find('first', ['conditions' => ['Attendees.id' => $id], 'fields' => ['id', 'user_id']]))) {
			$this->Flash->message(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(['action' => 'index']);
		}
		$var = $attendee['user_id'];

		if ($this->Attendees->delete($attendee)) {
			$this->Flash->message(__('record del {0} done', h($var)), 'success');
			return $this->Common->postRedirect(['action' => 'index']);
		}
		$this->Flash->message(__('record del {0} not done exception', h($var)), 'error');
		return $this->Common->autoRedirect(['action' => 'index']);
	}

	/**
	 * Notify attendees from last year that didnt yet join in.
	 *
	 * @return void
	 */
	public function notify() {
		$lastAttendees = $this->Attendees->getNotifyableAttendees();
		if ($this->Common->isPosted()) {
			if ($count = $this->_sendNotifications()) {
				$this->Flash->message(__('mails sent {0}', $count), 'success');
				return $this->Common->postRedirect(['action' => 'index']);
			}
			$this->Flash->message(__('formContainsErrors'), 'error');
		} else {
			$data = [];
			foreach ($lastAttendees as $attendee) {
				$data[$attendee['id']] = [
					'email' => $attendee->user['email'],
					'username' => $attendee->user['username'],
					'user_id' => $attendee->user['id'],
					'check' => true];
			}
			$this->request->data['Form'] = $data;

			$this->request->data['ContactForm'] = [
				'subject' => 'CakeFest' . date('Y'),
				'message' => 'You have been part of the CakeFest last year. Are you joining this year, as well?'
			];
		}
		$this->set(compact('lastAttendees'));
	}

	/**
	 * Notify attendees about invalid dates entered or alike.
	 *
	 * @return void
	 */
	public function notify_invalid() {
		$event = $this->Attendees->Events->find('all', ['order' => ['from' => 'DESC']])->first();

		$lastAttendees = $this->Attendees->find('all', ['conditions' => ['Attendees.event_id' => $event['id']]])->contain('Users');

		$lastAttendees = $lastAttendees->toArray();
		foreach ($lastAttendees as $key => $attendee) {
			if ($this->Attendees->validate($attendee)) {
				unset($lastAttendees[$key]);
			}
		}

		$this->loadModel('Tools.ContactForms');

		if ($this->Common->isPosted()) {
			if ($count = $this->_sendNotifications()) {
				$this->Flash->message(__('mails sent {0}', $count), 'success');
				return $this->Common->postRedirect(['action' => 'index']);
			}
			$this->Flash->message(__('formContainsErrors'), 'error');
		} else {
			$data = [];
			foreach ($lastAttendees as $attendee) {
				$data[$attendee['id']] = [
					'email' => $attendee->user->email,
					'username' => $attendee->user->username,
					'user_id' => $attendee->user->id,
					'check' => true];
			}

			$this->request->data = [
				'subject' => 'CakeFest ' . date('Y'),
				'message' => 'You signed up for CakeFest this year. But your submitted dates seem to be invalid. Can you please correct them?'
			];
			$this->request->data['Form'] = $data;
		}

		$this->set(compact('form', 'lastAttendees'));
		$this->render('notify');
	}

	/**
	 * AttendeesController::_sendNotifications()
	 *
	 * @return int Count
	 */
	protected function _sendNotifications($form) {
		if (empty($this->request->data['Form'])) {
			return 0;
		}

		if (!$this->ContactForms->validate($form)) {
			return 0;
		}

		$count = 0;
		foreach ($this->request->data['Form'] as $user) {
			if (!$this->_send($user, $this->request->data['ContactForm']['subject'], $this->request->data['ContactForm']['message'])) {
				continue;
			}
			$count++;

		}
		return $count;
	}

	/**
	 * @return bool Success
	 */
	protected function _send(array $user, $subject, $message) {
		$adminEmail = Configure::read('Config.adminEmail');
		$adminEmailname = Configure::read('Config.adminName');

		// Send email to Admin
		Configure::write('Email.live', true);
		$this->Email = new Email();
		$this->Email->to($user['email'], $user['username']);

		$this->Email->subject($subject);
		$this->Email->template('notify');
		$this->Email->viewVars(compact('message', 'user'));
		if ($this->Email->send()) {
			return true;
		}
		$this->log($this->Email->getError());
		return false;
	}

}
