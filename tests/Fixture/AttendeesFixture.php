<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AttendeeFixture
 *
 */
class AttendeesFixture extends TestFixture {

	/**
	 * Fields
	 *
	 * @var array
	 */
	public $fields = [
		'id' => ['type' => 'integer'],
		'from' => ['type' => 'datetime', 'null' => true],
		'to' => ['type' => 'datetime', 'null' => true],
		'display_email' => ['type' => 'boolean', 'null' => false, 'default' => '0'],
		'comment' => ['type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
		'event_id' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10],
		'user_id' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10],
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
			'from' => '2013-08-08 15:15:36',
			'to' => '2013-08-08 15:15:36',
			'display_email' => 1,
			'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'event_id' => 1,
			'user_id' => 1
		],
	];

}
