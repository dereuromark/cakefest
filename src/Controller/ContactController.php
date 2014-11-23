<?php
namespace App\Controller;

use Cake\Event\Event;
use App\Controller\AppController;
use Tools\Email\Email;
use Cake\Core\Configure;

class ContactController extends AppController {

	public $modelClass = 'Tools.ContactForms';

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow();
	}

	/**
	 * @return void
	 */
	public function index() {
		$contactForm = $this->ContactForms->newEntity($this->request->data);

		if ($this->Common->isPosted()) {

			$name = $this->request->data['ContactForm']['name'];
			$email = $this->request->data['ContactForm']['email'];
			$message = $this->request->data['ContactForm']['message'];
			$subject = $this->request->data['ContactForm']['subject'];

			if (!$this->AuthUser->id()) {
				//$this->ContactForm->addBehavior('Tools.Captcha');
			}
			if ($this->ContactForm->validate($contactForm)) {
				$this->_send($name, $email, $subject, $message);
			} else {
				$this->Common->flashMessage(__('formContainsErrors'), 'error');
			}

		} else {
			// prepopulate form
			$this->request->data['ContactForm'] = $this->request->query;

			# try to autofill fields
			$user = (array)$this->Session->read('Auth.User');
			if (!empty($user['email'])) {
				$this->request->data['ContactForm']['email'] = $user['email'];
			}
			if (!empty($user['username'])) {
				$this->request->data['ContactForm']['name'] = $user['username'];
			}
		}

		//$this->helpers = array_merge($this->helpers, array('Tools.Captcha'));
	}

	/**
	 * @return void
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
			$this->Common->flashMessage(__('contactSuccessfullySent {0}', $fromEmail), 'success');
			return $this->redirect(array('action' => 'index'));
		}
		$this->log($this->Email->getError());
		$this->Common->flashMessage(__('Contact Email could not be sent'), 'error');
	}

}
