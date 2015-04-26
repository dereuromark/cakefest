<?php
namespace App\Model\Table;

use App\Model\Table\AppTable;

/**
 * User Model
 *
 */
class UsersTable extends AppTable {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'username';

	/**
	 * Validation rules
	 *
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
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = [
		/*
		'Role' => array(
			'className' => 'Role',
			'foreignKey' => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Language' => array(
			'className' => 'Language',
			'foreignKey' => 'language_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
		*/
	];

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = [
		'Attendee' => [
			'className' => 'Attendee',
			'dependent' => true,
		]
	];

	public $filterArgs = [
		'search' => [
			'type' => 'like',
			'field' => ['username', 'email']
		],
		'role_id' => [
			'type' => 'value'
		],
		'status' => [
			'type' => 'value'
		]
	];

	public function initialize(array $config = []) {
		parent::initialize($config);

		$this->addBehavior('Search.Searchable');
	}

}
