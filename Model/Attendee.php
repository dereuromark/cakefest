<?php
App::uses('AppModel', 'Model');
/**
 * Attendee Model
 *
 * @property Event $Event
 * @property User $User
 */
class Attendee extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'user_id';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'from' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				'last' => true,
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isValidDate' => array(
				'rule' => array('isValidDate', 'from'),
				'message' => 'Please provide a valid date without the allowed range',
				'last' => true,
			)
		),
		'to' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				'last' => true,
			),
			'isValidDate' => array(
				'rule' => array('isValidDate', 'to'),
				'message' => 'Please provide a valid date without the allowed range',
				'last' => true,
			),
		),
		'display_email' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'event_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'last' => true
			),
			'isUnique' => array(
				'rule' => array('validateUnique', array('user_id')),
				'last' => true,
				'message' => 'You can only have one attendance entry per event'
			),
		),
		'user_id' => array(
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

	public function isValidDate($data, $key, $settings) {
		if (empty($this->data[$this->alias]['event_id'])) {
			return true;
		}
		$event = $this->Event->get($this->data[$this->alias]['event_id']);
		if (!$event) {
			throw new InternalErrorException();
		}
		$date = $data[$key];
		$dateTime = strtotime($date);
		$compareDate = $event['Event'][$key];
		$compareDateTime = strtotime($compareDate);
		switch ($key) {
			case 'from':
				if (!($dateTime >= $compareDateTime - 10 * DAY)) {
					return 'You cannot set a date before ' . date(FORMAT_DB_DATE, $compareDateTime);
				}
				return true;
			case 'to':
				if (!($dateTime <= $compareDateTime + 10 * DAY)) {
					return 'You cannot set a date after ' . date(FORMAT_DB_DATE, $compareDateTime);
				}
				return true;
		}

		return false;
	}

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Event' => array(
			'className' => 'Event',
			'foreignKey' => 'event_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
