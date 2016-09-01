<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use DateTimeZone;
use Tools\Controller\Controller;
use Tools\Utility\Language;

/**
 * @property \Tools\Controller\Component\FlashComponent $Flash
 * @property \Tools\Controller\Component\CommonComponent $Common
 * @property \Tools\Controller\Component\AuthUserComponent $AuthUser
 * @property \Shim\Controller\Component\SessionComponent $Session
 */
class AppController extends Controller {

	/**
	 * @var array
	 */
	public $components = ['Shim.Session', 'RequestHandler', 'Tools.Common', 'Tools.Flash', 'Tools.AuthUser'];

	/**
	 * @var array
	 */
	public $helpers = ['Shim.Session', 'Html', 'Tools.Form', 'Tools.Common', 'Tools.Flash',
		'Tools.Format', 'Tools.Time', 'Tools.Number', 'Tools.AuthUser', 'Tools.Obfuscate', 'Tools.Js'];

	/**
	 * @return void
	 */
	public function initialize() {
		parent::initialize();

		$this->loadComponent('TinyAuth.Auth', [
			'authenticate' => [
				'FOC/Authenticate.MultiColumn' => [
					'fields' => [
						'username' => 'login',
						'password' => 'password'
					],
					'columns' => ['username', 'email'],
					'userModel' => 'Users',
					'passwordHasher' => Configure::read('Passwordable.passwordHasher')
					//'scope' => array('User.email_confirmed' => 1)
				],
			],
			'authorize' => [
				'TinyAuth.Tiny'
			],
			'logoutRedirect' => [
				'plugin' => false,
				'admin' => false,
				'controller' => 'Overview',
				'action' => 'index'
			],
			'loginRedirect' => [
				'plugin' => false,
				'admin' => false,
				'controller' => 'Overview',
				'action' => 'index'
			],
			'loginAction' => [
				'plugin' => false,
				'admin' => false,
				'controller' => 'Account',
				'action' => 'login'
			],
			'unauthorizedRedirect' => [
				'plugin' => false,
				'admin' => false,
				'controller' => 'Overview',
				'action' => 'index'
			]
		]);
	}

	/**
	 * @param \Cake\Event\Event $event
	 * @return \Cake\Network\Response|null
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		// Do not allow access to these public actions when already logged in
		$allowed = ['Account' => ['login', 'lost_password', 'register']];
		if (!$this->AuthUser->id()) {
			return null;
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
		$matches = Language::parseLanguageList();
		$matches = [];
		if ($matches) {
			$locale = array_shift($matches);
			$locale = array_shift($locale);
			ini_set('intl.default_locale', $locale);
		} elseif ($timezone = $this->Session->read('Auth.User.timezone')) {
			$tz = new DateTimeZone($timezone);
			$country = $tz->getLocation();
			ini_set('intl.default_locale', $country['country_code']);
		}
	}

}
