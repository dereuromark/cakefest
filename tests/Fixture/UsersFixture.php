<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserFixture
 *
 */
class UsersFixture extends TestFixture {

	/**
	 * Fields
	 *
	 * @var array
	 */
	public $fields = [
		'id' => ['type' => 'integer'],
		'username' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
		'email' => ['type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
		'password' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 60, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
		'timezone' => ['type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
		'status' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2],
		'created' => ['type' => 'datetime', 'null' => true, 'default' => null],
		'modified' => ['type' => 'datetime', 'null' => true, 'default' => null],
		'role_id' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10],
		'language_id' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10],
		'_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']]],
		'_options' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB']
	];

	/**
	 * Records
	 *
	 * @var array
	 */
	public $records = [
		[
			'id' => 1,
			'username' => 'foo',
			'email' => 'foo@bar.de',
			'password' => 'hashed',
			'timezone' => '',
			'status' => 1,
			'created' => '2013-08-08 14:25:09',
			'modified' => '2013-08-08 14:25:09',
			'role_id' => 1,
			'language_id' => 1
		],
	];

}
