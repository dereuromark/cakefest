<?php
namespace App\Model\Table;

use App\Model\Table\AppTable;
use Cake\ORM\Query;
use Cake\I18n\Time;

/**
 * Attendee Table
 */
class AttendeesTable extends AppTable {

	public $order = array('Attendees.from' => 'ASC');

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
				'provider' => 'table'
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
				'provider' => 'table'
			),
			'validateDateTime' => array(
				'rule' => array('validateDateTime', array('after' => 'from')),
				'message' => 'This date must be after the from date',
				'last' => true,
				'provider' => 'table'
			),
		),
		'display_email' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
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
				'rule' => array('validateUnique', array('scope' => ['user_id'])),
				'last' => true,
				'message' => 'You can only have one attendance entry per event',
				'provider' => 'table'
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
	 * @param Time $date
	 * @param string $field
	 * @param mixed $settings
	 * @return boolean Success or string Error message.
	 * @throws InternalErrorException
	 */
	public function isValidDate(Time $date, $field, $context) {
		if (empty($context['data']['event_id'])) {
			return true;
		}//throw new \Exception();
		$event = $this->Events->get($context['data']['event_id']);
		$compareDate = $event[$field];
debug($compareDate);
		switch ($field) {
			case 'from':
				$compare = $compareDate->copy()->subDays(10);
				if (!($date->gte($compare))) {
					return 'You cannot set a date before ' . $compare->format(FORMAT_DB_DATE);
				}
				$compareDate = $event['to'];
				$compare = $compareDate->copy()->addDays(10);
				if (!($date->lte($compare))) {
					return 'You cannot set a date after ' . $compare->format(FORMAT_DB_DATE);
				}
				return true;
			case 'to':
				$compare = $compareDate->copy()->addDays(10);
				if (!($date->lte($compare))) {
					return 'You cannot set a date after ' . $compare->format(FORMAT_DB_DATE);
				}
				$compareDate = $event['from'];
				$compare = $compareDate->copy()->subDays(10);
				if (!($date->gte($compare))) {
					return 'You cannot set a date before ' . $compare->format(FORMAT_DB_DATE);
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
		$last = $this->Events->find('first', array('order' => array('from' => 'DESC')));
		$current = $this->Events->find('first', array('conditions' => array('id !=' => $last['id']), 'order' => array('from' => 'DESC')));

		$currentAttendees = $this->find('all', array('conditions' => array('Attendees.event_id' => $current['id'])));
		$currentUserList = Hash::extract($currentAttendees, '{n}.Attendees.user_id');
		$lastAttendees = $this->find('all', array('contain' => array('Users'), 'conditions' => array('Attendees.user_id NOT' => $currentUserList, 'Attendees.event_id' => $last['id'])));
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

	/**
	 * Find all of this year only.
	 *
	 * @param Query $query
	 * @param array $options
	 * @return Query
	 */
	public function findUpcoming(Query $query, array $options) {
		$query->contain('Events');
		$query->where([
			'Events.to >=' => date('Y') . '-01-01'
		]);
		return $query;
	}

}
