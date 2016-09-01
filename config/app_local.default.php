<?php
$config = [
	//'debug' => true,

	'Security' => [
		'salt' => '1ebcb009bb3f8ebe43a4addc3fc1c1f310c50520',
	],

	'Datasources' => [
		'default' => [
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'database' => 'cake_cakefest',
		],

		/**
		 * The test connection is used during the test suite.
		 */
		'test' => [
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'database' => 'cake_test',
		],
	],

	'Config' => [
		'adminEmail' => 'youreemail@example.de'
	],

	'FormConfig' => [
		'novalidate' => true,
		'templates' => [
			'dateWidget' => '{{day}}{{month}}{{year}}{{hour}}{{minute}}{{second}}{{meridian}}',
		]
	]

];
