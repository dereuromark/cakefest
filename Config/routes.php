<?php

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
Router::connect('/', array('controller' => 'overview', 'action' => 'index'));

Router::connect('/login', array('controller' => 'account', 'action' => 'login'));
Router::connect('/logout', array('controller' => 'account', 'action' => 'logout'));
Router::connect('/register', array('controller' => 'account', 'action' => 'register'));

Router::connect('/admin', array('controller' => 'overview', 'action' => 'admin'));

/**
* ...and connect the rest of 'Pages' controller's URLs.
*/
Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
* Load all plugin routes. See the CakePlugin documentation on
* how to customize the loading of plugin routes.
*/
Plugin::routes();

/**
* Load the CakePHP default routes. Only remove this if you do not want to use
* the built-in default routes.
*/
require CAKE . 'Config' . DS . 'routes.php';
