<?php
namespace App\Controller;

use Cake\Event\Event;
use Tools\Controller\Controller;
use Cake\Core\Plugin;
use Cake\Core\Configure;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 */
class AppController extends Controller {

	public $components = array('Session', 'RequestHandler', 'Tools.Common', 'Auth', 'Tools.AuthUser');

	public $helpers = array('Session', 'Html', 'Form', 'Tools.Common',
		'Tools.Format', 'Tools.Datetime', 'Tools.Numeric', 'Tools.AuthUser');

	/**
	 * AppController::constructClasses()
	 *
	 * @return void
	 */
	public function initialize() {
		if (Plugin::loaded('DebugKit') && Configure::read('debug')) {
			//$this->components[] = 'DebugKit.Toolbar';
		}
	}

	/**
	 * AppController::beforeFilter()
	 *
	 * @return void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->authenticate = array(
			'Authenticate.MultiColumn' => array(
				'fields' => array(
					'username' => 'login',
					'password' => 'password'
				),
				'columns' => array('username', 'email'),
				'userModel' => 'User',
				//'scope' => array('User.email_confirmed' => 1)
			)
		);
		$this->Auth->authorize = array(
			'Tools.Tiny' => array()
		);
		$this->Auth->logoutRedirect = array(
			'plugin' => false,
			'admin' => false,
			'controller' => 'overview',
			'action' => 'index');
		$this->Auth->loginRedirect = array(
			'plugin' => false,
			'admin' => false,
			'controller' => 'overview',
			'action' => 'index');
		$this->Auth->loginAction = array(
			'plugin' => false,
			'admin' => false,
			'controller' => 'account',
			'action' => 'login');

		// Do not allow access to these public actions when already logged in
		$allowed = array('Account' => array('login', 'lost_password', 'register'));
		if (!$this->AuthUser->id()) {
			return;
		}
		foreach ($allowed as $controller => $actions) {
			if ($this->name === $controller && in_array($this->request->action, $actions)) {
				$this->Common->flashMessage('The page you tried to access is not relevant if you are already logged in. Redirected to main page.', 'info');
				return $this->redirect($this->Auth->loginRedirect);
			}
		}

		$this->paginate['paramType'] = 'querystring';
	}

}
