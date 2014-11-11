<?php
namespace App\Controller;

use Cake\Event\Event;
use App\Controller\AppController;

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
		$this->Attendee->recursive = 0;
		$attendees = $this->paginate();
		$this->set(compact('attendees'));
	}

	/**
	 * view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		$this->Attendee->recursive = 0;
		if (empty($id) || !($attendee = $this->Attendee->find('first', array('conditions' => array('Attendees.id' => $id))))) {
			$this->Common->flashMessage(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
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
		if (empty($id) || !($attendee = $this->Attendee->find('first', array('conditions' => array('Attendees.id' => $id))))) {
			$this->Common->flashMessage(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
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
		if (empty($id) || !($attendee = $this->Attendee->find('first', array('conditions' => array('Attendees.id' => $id), 'fields' => array('id', 'user_id'))))) {
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

	/**
	 * Notify attendees from last year that didnt yet join in.
	 *
	 * @return void
	 */
	public function notify() {
		$lastAttendees = $this->Attendee->getNotifyableAttendees();
		if ($this->Common->isPosted()) {
			if ($count = $this->_sendNotifications()) {
				$this->Common->flashMessage(__('mails sent %s', $count), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			}
			$this->Common->flashMessage(__('formContainsErrors'), 'error');
		} else {
			$data = array();
			foreach ($lastAttendees as $attendee) {
				$data[$attendee['Attendee']['id']] = array(
					'email' => $attendee['User']['email'],
					'username' => $attendee['User']['username'],
					'user_id' => $attendee['User']['id'],
					'check' => true);
			}
			$this->request->data['Form'] = $data;

			$this->request->data['ContactForm'] = array(
				'subject' => 'CakeFest' . date('Y'),
				'message' => 'You have been part of the CakeFest last year. Are you joining this year, as well?'
			);
		}
		$this->set(compact('lastAttendees'));
	}

	/**
	 * AttendeesController::_sendNotifications()
	 *
	 * @return int Count
	 */
	protected function _sendNotifications() {
		if (empty($this->request->data['Form'])) {
			return 0;
		}
		$this->loadModel('Tools.ContactForm');
		$this->ContactForm->set($this->request->data);
		if (!$this->ContactForm->validates()) {
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
		use Tools\EmailLib;
		$this->Email = new EmailLib();
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

	/**
	 * Notify attendees about invalid dates entered or alike.
	 *
	 * @return void
	 */
	public function notify_invalid() {
		$event = $this->Attendee->Event->find('first', array('order' => array('from' => 'DESC')));

		$lastAttendees = $this->Attendee->find('all', array('contain' => array('User'), 'conditions' => array('Attendees.event_id' => $event['Event']['id'])));

		foreach ($lastAttendees as $key => $attendee) {
			$this->Attendee->set($attendee);
			if ($this->Attendee->validates()) {
				unset($lastAttendees[$key]);
			}
		}

		if ($this->Common->isPosted()) {
			if ($count = $this->_sendNotifications()) {
				$this->Common->flashMessage(__('mails sent %s', $count), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			}
			$this->Common->flashMessage(__('formContainsErrors'), 'error');
		} else {
			$data = array();
			foreach ($lastAttendees as $attendee) {
				$data[$attendee['Attendee']['id']] = array(
					'email' => $attendee['User']['email'],
					'username' => $attendee['User']['username'],
					'user_id' => $attendee['User']['id'],
					'check' => true);
			}
			$this->request->data['Form'] = $data;

			$this->request->data['ContactForm'] = array(
				'subject' => 'CakeFest ' . date('Y'),
				'message' => 'You signed up for CakeFest this year. But your submitted dates seem to be invalid. Can you please correct them?'
			);
		}

		$this->set(compact('lastAttendees'));
		$this->render('notify');
	}

}
