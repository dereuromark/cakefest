<?php
namespace App\Model\Table;

use App\Model\Table\AppTable;

/**
 * Event Model
 */
class EventsTable extends AppTable {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'name';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = [
		'from' => [
			'datetime' => [
				'rule' => ['date'],
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			],
		],
		'to' => [
			'datetime' => [
				'rule' => ['date'],
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			],
		],
		'name' => [
			'notEmpty' => [
				'rule' => ['notBlank'],
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			],
		],
	];

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = [
		'Attendee' => [
			//'className' => 'Attendee',
			'foreignKey' => 'event_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
		]
	];

}
