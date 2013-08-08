<?php
App::uses('MyController', 'Tools.Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends MyController {

	public $components = array('Session', 'RequestHandler', 'Tools.Common', 'Auth');

	public $helpers = array('Session', 'Html', 'Form' => array('className' => 'Tools.FormExt'), 'Tools.Common', 'Tools.Format', 'Tools.Datetime', 'Tools.Numeric');

	/**
	 * AppController::constructClasses()
	 *
	 * @return void
	 */
	public function constructClasses() {
		if (CakePlugin::loaded('DebugKit')) {
			$this->components[] = 'DebugKit.Toolbar';
		}

		parent::constructClasses();
	}

	/**
	 * AppController::beforeFilter()
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();
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
		$this->Auth->logoutRedirect = '/';
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
	}

}
