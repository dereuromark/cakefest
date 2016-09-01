<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Tools\Form\ContactForm;
use Tools\Mailer\Email;

class ContactController extends AppController {

	/**
	 * @return void
	 */
	public function index() {
		$contact = new ContactForm();

		if ($this->Common->isPosted()) {

			$name = $this->request->data['name'];
			$email = $this->request->data['email'];
			$message = $this->request->data['message'];
			$subject = $this->request->data['subject'];

			if (!$this->AuthUser->id()) {
				//$this->ContactForm->addBehavior('Tools.Captcha');
			}
			if ($contact->execute($this->request->data)) {
				$this->_send($name, $email, $subject, $message);
			} else {
				$this->Flash->message(__('formContainsErrors'), 'error');
			}

		} else {
			// prepopulate form
			$this->request->data = $this->request->query;

			# try to autofill fields
			$user = (array)$this->Session->read('Auth.User');
			if (!empty($user['email'])) {
				$this->request->data['email'] = $user['email'];
			}
			if (!empty($user['username'])) {
				$this->request->data['name'] = $user['username'];
			}
		}

		//$this->helpers = array_merge($this->helpers, array('Tools.Captcha'));
		$this->set(compact('contact'));
	}

	/**
	 * @param string $fromName
	 * @param string $fromEmail
	 * @param string $subject
	 * @param string $message
	 * @return \Cake\Network\Response|null
	 */
	protected function _send($fromName, $fromEmail, $subject, $message) {
		$adminEmail = Configure::read('Config.adminEmail');
		$adminEmailname = Configure::read('Config.adminName');

		// Send email to Admin
		Configure::write('Email.live', true);
		$this->Email = new Email();
		$this->Email->to($adminEmail, $adminEmailname);

		$this->Email->subject(Configure::read('Config.pageName') . ' - ' . __('contact via form'));
		$this->Email->template('contact');
		$this->Email->viewVars(compact('message', 'subject', 'fromEmail', 'fromName'));
		if ($this->Email->send()) {
			$this->Flash->message(__('contactSuccessfullySent {0}', $fromEmail), 'success');
			return $this->redirect(['action' => 'index']);
		}
		if (Configure::read('debug')) {
			$this->Flash->warning($this->Email->getError());
		}
		$this->log($this->Email->getError());
		$this->Flash->message(__('Contact Email could not be sent'), 'error');
	}

}
