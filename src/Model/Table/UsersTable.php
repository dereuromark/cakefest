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
	public $validate = array(
		'username' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				'last' => true,
			),
			'isUnique' => array(
				'rule' => array('validateUnique'),
				'message' => 'This username has already been taken',
				'last' => true,
				'provider' => 'table'
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Please provide a valid email address',
				'last' => true,
			),
			'isUnique' => array(
				'rule' => array('validateUnique'),
				'message' => 'This username has already been taken',
				'last' => true,
				'provider' => 'table'
			),
		),
		'status' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'role_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'language_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
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
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Attendee' => array(
			'className' => 'Attendee',
			'dependent' => true,
		)
	);

}
