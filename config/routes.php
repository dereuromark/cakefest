<?php

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
	$routes->connect('/', ['controller' => 'Overview', 'action' => 'index']);

	$routes->connect('/login', ['controller' => 'Account', 'action' => 'login']);
	$routes->connect('/logout', ['controller' => 'Account', 'action' => 'logout']);
	$routes->connect('/register', ['controller' => 'Account', 'action' => 'register']);

	$routes->connect('/admin', ['controller' => 'Overview', 'action' => 'admin']);

	$routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

	$routes->fallbacks();
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
