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

	public $components = array('Session', 'RequestHandler', 'Tools.Common');

	public $helpers = array('Session', 'Html', 'Form' => array('className' => 'Tools.FormExt'), 'Tools.Common', 'Tools.Format', 'Tools.Datetime', 'Tools.Numeric');

}
