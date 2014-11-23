<?php
/**
 * Test runner bootstrap.
 *
 * Add additional configuration/setup your application needs when running
 * unit tests in this file.
 */
require dirname(__DIR__) . '/config/bootstrap.php';

$Tmp = new Cake\Filesystem\Folder(TMP);
$Tmp->create(TMP . 'cache/models', 0770);
$Tmp->create(TMP . 'cache/persistent', 0770);
$Tmp->create(TMP . 'cache/views', 0770);
$Tmp->create(TMP . 'logs', 0770);

// Ensure default test connection is defined
if (!getenv('db_class')) {
	putenv('db_class=Cake\Database\Driver\Sqlite');
	putenv('db_dsn=sqlite::memory:');
}

Cake\Datasource\ConnectionManager::drop('test');

if (WINDOWS) {
	Cake\Datasource\ConnectionManager::config('test', [
		'className' => 'Cake\Database\Connection',
		'driver' => 'Cake\Database\Driver\Mysql',
		'database' => 'cake_test',
		'username' => 'root',
		'password' => '',
		'timezone' => 'UTC',
		'quoteIdentifiers' => true,
		'cacheMetadata' => true,
	]);
	return;
}

Cake\Datasource\ConnectionManager::config('test', [
	'className' => 'Cake\Database\Connection',
	'driver' => getenv('db_class'),
	'dsn' => getenv('db_dsn'),
	'database' => getenv('db_database'),
	'username' => getenv('db_username'),
	'password' => getenv('db_password'),
	'timezone' => 'UTC',
	'quoteIdentifiers' => true,
	'cacheMetadata' => true,
]);
