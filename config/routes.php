<?php

use Cake\Routing\Router;
use Cake\Core\Plugin;

Router::defaultRouteClass('InflectedRoute');

Router::scope('/', function ($routes) {

/**
 * Here, we are connecting '/' (base path) to a controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, src/Template/Pages/home.ctp)...
 */
	$routes->connect('/', ['controller' => 'Overview', 'action' => 'index']);

	$routes->connect('/login', array('controller' => 'Account', 'action' => 'login'));
	$routes->connect('/logout', array('controller' => 'Account', 'action' => 'logout'));
	$routes->connect('/register', array('controller' => 'Account', 'action' => 'register'));

	$routes->connect('/admin', array('controller' => 'Overview', 'action' => 'admin'));

/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	$routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

/**
 * Connect a route for the index action of any controller.
 * And a more general catch all route for any action.
 *
 * The `fallbacks` method is a shortcut for
 *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'InflectedRoute']);`
 *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'InflectedRoute']);`
 *
 * You can remove these routes once you've connected the
 * routes you want in your application.
 */
	//$routes->fallbacks();
	$routes->connect('/:controller', ['action' => 'index']);
	$routes->connect('/:controller/:action/*');
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
