<?php
namespace App\Model\Table;

use App\Model\Table\AppTable;

/**
 * Attendee Table
 */
class AttendeesTable extends AppTable {

	public $order = array('Attendee.from' => 'ASC');

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
				'last' => true,
			),
			'isValidDate' => array(
				'rule' => array('isValidDate', 'from'),
				'message' => 'Please provide a valid date within the allowed range',
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
				'message' => 'Please provide a valid date within the allowed range',
				'last' => true,
			),
			'validateDateTime' => array(
				'rule' => array('validateDateTime', array('after' => 'from')),
				'message' => 'This date must be after the from date',
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

	/**
	 * Attendee::isValidDate()
	 *
	 * @param mixed $data
	 * @param mixed $key
	 * @param mixed $settings
	 * @return boolean Success or string Error message.
	 * @throws InternalErrorException
	 */
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
					return 'You cannot set a date before ' . date(FORMAT_DB_DATE, $compareDateTime - 10 * DAY);
				}
				$compareDate = $event['Event']['to'];
				$compareDateTime = strtotime($compareDate);
				if (!($dateTime <= $compareDateTime + 10 * DAY)) {
					return 'You cannot set a date after ' . date(FORMAT_DB_DATE, $compareDateTime + 10 * DAY);
				}
				return true;
			case 'to':
				if (!($dateTime <= $compareDateTime + 10 * DAY)) {
					return 'You cannot set a date after ' . date(FORMAT_DB_DATE, $compareDateTime + 10 * DAY);
				}
				$compareDate = $event['Event']['from'];
				$compareDateTime = strtotime($compareDate);
				if (!($dateTime >= $compareDateTime - 10 * DAY)) {
					return 'You cannot set a date before ' . date(FORMAT_DB_DATE, $compareDateTime - 10 * DAY);
				}
				return true;
		}

		return false;
	}

	/**
	 * Attendee::getNotifyableAttendees()
	 *
	 * @return array
	 */
	public function getNotifyableAttendees() {
		$last = $this->Event->find('first', array('order' => array('from' => 'DESC')));
		$current = $this->Event->find('first', array('conditions' => array('id !=' => $last['Event']['id']), 'order' => array('from' => 'DESC')));

		$currentAttendees = $this->find('all', array('conditions' => array('Attendee.event_id' => $current['Event']['id'])));
		$currentUserList = Hash::extract($currentAttendees, '{n}.Attendee.user_id');
		$lastAttendees = $this->find('all', array('contain' => array('User'), 'conditions' => array('Attendee.user_id NOT' => $currentUserList, 'Attendee.event_id' => $last['Event']['id'])));
		return $lastAttendees;
	}

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Event' => array(
			//'className' => 'Event',
			'foreignKey' => 'event_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			//'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
