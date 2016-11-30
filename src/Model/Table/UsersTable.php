<?php
namespace App\Model\Table;

use App\Model\Table\AppTable;

/**
 * @mixin \Search\Model\Behavior\SearchBehavior
 */
class UsersTable extends AppTable {

	/**
	 * @var string
	 */
	public $displayField = 'username';

	/**
	 * @var array
	 */
	public $validate = [
		'username' => [
			'notEmpty' => [
				'rule' => ['notBlank'],
				//'message' => 'Your custom message here',
				'last' => true,
			],
			'isUnique' => [
				'rule' => ['validateUnique'],
				'message' => 'This username has already been taken',
				'last' => true,
				'provider' => 'table'
			],
		],
		'email' => [
			'email' => [
				'rule' => ['email'],
				'message' => 'Please provide a valid email address',
				'last' => true,
			],
			'isUnique' => [
				'rule' => ['validateUnique'],
				'message' => 'This username has already been taken',
				'last' => true,
				'provider' => 'table'
			],
		],
		'status' => [
			'numeric' => [
				'rule' => ['numeric'],
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			],
		],
		'role_id' => [
			'numeric' => [
				'rule' => ['numeric'],
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			],
		],
		'language_id' => [
			'numeric' => [
				'rule' => ['numeric'],
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			],
		],
	];

	/**
	 * @var array
	 */
	public $hasMany = [
		'Attendee' => [
			'className' => 'Attendee',
			'dependent' => true,
		]
	];

	/**
	 * @param array $config
	 * @return void
	 */
	public function initialize(array $config = []) {
		parent::initialize($config);

		$this->addBehavior('Search.Search');

		$this->searchManager()
			->value('role_id')
			->value('status')
			->add('search', 'Search.Like', [
				'before' => true,
				'after' => true,
				'field' => ['username', 'email']
			]);
	}

}
