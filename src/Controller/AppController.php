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

	public $components = array('Shim.Session', 'RequestHandler', 'Tools.Common', 'Tools.Flash', 'Tools.AuthUser');

	public $helpers = array('Session', 'Html', 'Tools.Form', 'Tools.Common', 'Tools.Flash',
		'Tools.Format', 'Tools.Time', 'Tools.Number', 'Tools.AuthUser', 'Tools.Obfuscate', 'Tools.Js');

	/**
	 * AppController::constructClasses()
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();

		$this->loadComponent('Auth', array(
			'authenticate' => array(
				'FOC/Authenticate.MultiColumn' => array(
					'fields' => array(
						'username' => 'login',
						'password' => 'password'
					),
					'columns' => array('username', 'email'),
					'userModel' => 'Users',
					'passwordHasher' => Configure::read('Passwordable.passwordHasher')
					//'scope' => array('User.email_confirmed' => 1)
				),
			),
			'authorize' => array(
				'TinyAuth.Tiny'
			),
			'logoutRedirect' => array(
				'plugin' => false,
				'admin' => false,
				'controller' => 'Overview',
				'action' => 'index'
			),
			'loginRedirect' => array(
				'plugin' => false,
				'admin' => false,
				'controller' => 'Overview',
				'action' => 'index'
			),
			'loginAction' => array(
				'plugin' => false,
				'admin' => false,
				'controller' => 'Account',
				'action' => 'login'
			),
			'unauthorizedRedirect' => array(
				'plugin' => false,
				'admin' => false,
				'controller' => 'Overview',
				'action' => 'index'
			)
		));
	}

	/**
	 * AppController::beforeFilter()
	 *
	 * @return void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		// Do not allow access to these public actions when already logged in
		$allowed = array('Account' => array('login', 'lost_password', 'register'));
		if (!$this->AuthUser->id()) {
			return;
		}
		foreach ($allowed as $controller => $actions) {
			if ($this->name === $controller && in_array($this->request->action, $actions)) {
				$this->Flash->message('The page you tried to access is not relevant if you are already logged in. Redirected to main page.', 'info');
				return $this->redirect($this->Auth->config('loginRedirect'));
			}
		}

		// Locale detection
		//preg_match('/([a-z]{2})-([A-Z]{2})/', env('HTTP_ACCEPT_LANGUAGE'), $matches);
		//TODO: use request->parseLanguage stuff instead()
		$matches = \Tools\Utility\Language::parseLanguageList();
		$matches = array();
		if ($matches) {
			$locale = array_shift($matches);
			$locale = array_shift($locale);
			ini_set('intl.default_locale', $locale);
		} elseif ($timezone = $this->Session->read('Auth.User.timezone')) {
			$tz = new \DateTimeZone($timezone);
			$country = $tz->getLocation();
			ini_set('intl.default_locale', $country['country_code']);
		}
	}

}
