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

	'Passwordable' => [
		'passwordHasher' => ['className' => 'Fallback', 'hashers' => ['Default', 'Weak']]
	],

	'Log' => [
		'debug' => [
			'scopes' => false,
		],
		'error' => [
			'scopes' => false,
		],
	],

	'Roles' => [
		'admin' => '1',
		'user' => '2',
	],

	'Config' => [
		'pageName' => 'CakeFest App',
		'adminEmail' => '', // Overwrite in app_local.php
		'adminName' => 'Mark',
		'rememberMe' => false,
	],

	'Asset' => [
		'js' => 'buffer'
	],

	// Please provide the following using the app_locale.php which is not under version control
	'Email' => [
		'default' => [
		]
	],

	'EmailTransport' => [
		'default' => [
			'host' => '',
			'username' => '',
			'password' => ''
		]
	]
];
