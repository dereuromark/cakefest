<?php
namespace App\Model\Table;

/**
 * @mixin \Search\Model\Behavior\SearchBehavior
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table {

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
