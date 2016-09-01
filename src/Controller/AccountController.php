<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\InternalErrorException;
use Tools\View\Helper\ObfuscateHelper;
use Tools\Mailer\Email;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class AccountController extends AppController {

	/**
	 * @var string
	 */
	public $modelClass = 'Users';

	/**
	 * @return \Cake\Network\Response|null
	 */
	public function login() {
		if ($this->Common->isPosted()) {
			$user = $this->Auth->identify();
			if ($user) {
				$this->Users->addBehavior('Tools.Passwordable', ['confirm' => false]);
				$password = $this->request->data['password'];
				$dbPassword = $this->Users->field('password', ['id' => $user['id']]);

				if ($this->Users->needsPasswordRehash($dbPassword)) {
					$data = [
						'id' => $user['id'],
						'pwd' => $password,
						'modified' => false
					];
					$updatedUser = $this->Users->newEntity($data, ['markNew' => false]);
					if (!$this->Users->save($updatedUser, ['validate' => false])) {
						trigger_error(sprintf('Could not store new pwd for user %s.', $user['id']));
					}
				}
				unset($user['password']);
				$this->Auth->setUser($user);
				$this->Flash->message(__('loggedInMessage'), 'success');
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Flash->message(__('loggedInError'), 'error');
			$this->request->data['password'] = '';

		} else {
			$username = $this->request->query('username');
			if ($username) {
				$this->request->data['login'] = $username;
			}
		}
	}

	/**
	 * @return \Cake\Network\Response|null
	 */
	public function logout() {
		$whereTo = $this->Auth->logout();
		// Delete cookie
		if (Configure::read('Config.rememberMe')) {
			$this->Common->loadComponent('Tools.RememberMe');
			$this->RememberMe->delete();
		}
		$this->Flash->message(__('loggedOutMessage'), 'success');
		return $this->redirect($whereTo);
	}

	/**
	 * AccountController::lost_password()
	 *
	 * @param string|null $key
	 * @return \Cake\Network\Response|null
	 */
	public function lostPassword($key = null) {
		$user = $this->Users->newEntity();

		if ($this->Common->isPosted()) {
			$keyToCheck = $this->request->data('Form.key');
		} elseif (!empty($key)) {
			$keyToCheck = $key;
		}

		if (!empty($keyToCheck)) {
			$this->Tokens = TableRegistry::get('Tools.Tokens');
			$key = $this->Tokens->useKey('reset_pwd', $keyToCheck);

			if (!empty($key) && $key['used'] == 1) {
				$this->Flash->message(__('alreadyChangedYourPassword'), 'warning');
			} elseif (!empty($key)) {
				$uid = $key['user_id'];
				$this->request->session()->write('Auth.Tmp.id', $uid);
				return $this->redirect(['action' => 'change_password']);
			} else {
				$this->Flash->message(__('Invalid Key'), 'error');
			}

		} elseif (!empty($this->request->data['Form']['login'])) {
			//$this->Users->addBehavior('Tools.Captcha');
			unset($this->Users->validate['email']['isUnique']);

			$user = $this->Users->patchEntity($user, $this->request->data);

			// Validate basic email scheme and captcha input.
			if (!$user->errors()) {
				$res = $this->Users->find('first', [
					'fields' => ['username', 'id', 'email'],
					'conditions' => ['email' => $this->request->data['Form']['login']]]);

				// Valid user found to this email address
				if (!empty($res)) {
					$uid = $res['id'];
					$this->Tokens = TableRegistry::get('Tools.Tokens');
					$cCode = $this->Tokens->newKey('reset_pwd', null, $uid);
					if (Configure::read('debug') > 0) {
						$debugMessage = 'DEBUG MODE: Show activation key - ' . h($res->user['username']) . ' | ' . $cCode;
						$this->Flash->info($debugMessage);
					}

					// Send email
					Configure::write('Email.live', true);

					$this->Email = new Email();
					$this->Email->to($res['email'], $res['username']);
					$this->Email->subject(Configure::read('Config.pageName') . ' - ' . __('Password request'));
					$this->Email->template('lost_password');
					$this->Email->viewVars(compact('cCode'));
					if ($this->Email->send()) {
						// Confirmation output
						$email = h(ObfuscateHelper::hideEmail($res['email']));

						$this->Flash->success(__('An email with instructions has been send to \'\'{0}\'\'.', $email));
						$this->Flash->success(__('In a third step you will then be able to change your password.'));
					} else {
						$this->Flash->error(__('Confirmation Email could not be sent. Please consult an admin.'));
					}
					return $this->redirect(['action' => 'lost_password']);
				}
				$this->Flash->error(__('No account has been found for \'{0}\'', $this->request->data['Form']['login']));
			}
		}

		//$this->helpers = array_merge($this->helpers, array('Tools.Captcha'));
		$this->set(compact('user'));
	}

	/**
	 * @return \Cake\Network\Response|null
	 */
	public function changePassword() {
		$uid = $this->request->session()->read('Auth.Tmp.id');
		if (empty($uid)) {
			$this->Flash->message(__('You have to find your account first and click on the link in the email you receive afterwards'), 'error');
			return $this->redirect(['action' => 'lost_password']);
		}

		if ($this->request->query('abort')) {
			if (!empty($uid)) {
				$this->request->session()->delete('Auth.Tmp');
			}
			return $this->redirect(['action' => 'login']);
		}

		$user = $this->Users->newEntity();

		$this->Users->addBehavior('Tools.Passwordable', []);
		if ($this->Common->isPosted()) {
			$user = $this->Users->patchEntity($user, $this->request->data);
			$user->id = $uid;
			$options = [
				'fieldList' => ['id', 'pwd', 'pwd_repeat']
			];
			if ($this->Users->save($user, $options)) {
				$this->Flash->message(__('new pw saved - you may now log in'), 'success');
				$this->request->session()->delete('Auth.Tmp');
				$username = $this->Users->fieldByConditions('username', ['id' => $uid]);
				return $this->Common->postRedirect(['action' => 'login', '?' => ['username' => $username]]);
			}
			$this->Flash->message(__('formContainsErrors'), 'error');

			// Pwd should not be passed to the view again for security reasons.
			unset($this->request->data['pwd']);
			unset($this->request->data['pwd_repeat']);
		}

		$this->set(compact('user'));
	}

	/**
	 * @return \Cake\Network\Response|null
	 */
	public function register() {
		$user = $this->Users->newEntity();
		$this->Users->addBehavior('Tools.Passwordable');

		if ($this->Common->isPosted()) {
			$user = $this->Users->patchEntity($user, $this->request->data);
			$user->role_id = Configure::read('Roles.user');

			if ($this->Users->save($user)) {
				$this->Flash->message(__('Account created'), 'success');
				// Log in right away
				$this->Auth->setUser($user->toArray());
				return $this->redirect(['controller' => 'Overview', 'action' => 'index']);
			}
			$this->Flash->message(__('formContainsErrors'), 'error');
			// pwd should not be passed to the view again for security reasons
			//$user->unsetProperty('pwd');
			//$user->unsetProperty('pwd_repeat');
			unset($this->request->data['pwd']);
			unset($this->request->data['pwd_repeat']);
		}

		$this->set(compact('user'));
	}

	/**
	 * @return \Cake\Network\Response|null
	 * @throws \Exception
	 */
	public function edit() {
		$uid = $this->request->session()->read('Auth.User.id');
		$user = $this->Users->get($uid);
		$this->Users->addBehavior('Tools.Passwordable', ['require' => false]);

		if ($this->Common->isPosted()) {
			//$user->id = $uid;
			$options = [
				//'validate' => true,
				//'fieldList' => array('id', 'username', 'email', 'irc_nick', 'pwd', 'pwd_repeat')
			];
			$user = $this->Users->patchEntity($user, $this->request->data);
			if ($this->Users->save($user, $options)) {
				// Update session data, as well
				$this->Flash->success(__('Account modified'));
				$this->Auth->setUser($user->toArray());
				return $this->redirect(['controller' => 'Overview', 'action' => 'index']);
			}
			$this->Flash->error(__('formContainsErrors'));

			// Pwd should not be passed to the view again for security reasons.
			unset($this->request->data['pwd']);
			unset($this->request->data['pwd_repeat']);
		}

		$this->set(compact('user'));
	}

	/**
	 * AccountController::delete()
	 *
	 * @param mixed $id
	 * @return \Cake\Network\Response|null
	 * @throws InternalErrorException
	 */
	public function delete($id = null) {
		$this->request->allowMethod(['post', 'delete']);
		$uid = $this->request->session()->read('Auth.User.id');
		$user = $this->Users->get($uid);
		if (!$this->Users->delete($user)) {
			throw new InternalErrorException();
		}
		$this->Flash->message('Account deleted', 'success');
		return $this->redirect(['action' => 'logout']);
	}

}
