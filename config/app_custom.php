<?php
return [
	'Datasources' => [
		'default' => [
			'quoteIdentifiers' => true,
		],
		'test' => [
			'quoteIdentifiers' => true,
		]
	],

	'Session' => [
		'timeout' => 3 * DAY,
		'cookieTimeout' => MONTH
	],
	'Roles' => array(
		'admin' => '1',
		'user' => '2',
	),
	'Config' => array(
		'pageName' => 'CakeFest App',
		'adminEmail' => '', // Overwrite in app_local.php
		'adminName' => 'Mark',
		'rememberMe' => false,
	),
	'Asset' => array(
		'js' => 'buffer'
	),
/* Please provide the following using the configs_private.php which is not under version control */
	'Email' => array(
		'Smtp' => array(
			'host' => '',
			'username' => '',
			'password' => ''
		)
	)
];
