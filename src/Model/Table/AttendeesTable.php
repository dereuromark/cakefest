<?php
namespace App\Model\Table;

use App\Model\Table\AppTable;
use Cake\ORM\Query;
use Tools\Utility\Time;

/**
 * Attendee Table
 */
class AttendeesTable extends AppTable {

	public $order = ['from' => 'ASC'];

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
	public $validate = [
		'from' => [
			'datetime' => [
				'rule' => ['datetime'],
				//'message' => 'Your custom message here',
				'last' => true,
			],
			'isValidDate' => [
				'rule' => ['isValidDate', 'from'],
				'message' => 'Please provide a valid date within the allowed range',
				'last' => true,
				'provider' => 'table'
			]
		],
		'to' => [
			'datetime' => [
				'rule' => ['datetime'],
				'last' => true,
			],
			'isValidDate' => [
				'rule' => ['isValidDate', 'to'],
				'message' => 'Please provide a valid date within the allowed range',
				'last' => true,
				'provider' => 'table'
			],
			'validateDateTime' => [
				'rule' => ['validateDateTime', ['after' => 'from']],
				'message' => 'This date must be after the from date',
				'last' => true,
				'provider' => 'table'
			],
		],
		'display_email' => [
			'boolean' => [
				'rule' => ['boolean'],
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			],
		],
		'event_id' => [
			'numeric' => [
				'rule' => ['numeric'],
				'last' => true
			],
			'isUnique' => [
				'rule' => ['validateUniqueExt', ['scope' => ['user_id']]],
				'last' => true,
				'message' => 'You can only have one attendance entry per event',
				'provider' => 'table'
			],
		],
		'user_id' => [
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
	 * Attendee::isValidDate()
	 *
	 * @param Time $date
	 * @param string $field
	 * @param mixed $settings
	 * @return boolean Success or string Error message.
	 * @throws InternalErrorException
	 */
	public function isValidDate($date, $field, $context) {
		if (empty($context['data']['event_id'])) {
			return true;
		}
		//die(debug($context['providers']['table']->schema()));
		if (!is_object($date)) {
			$date = new Time($date);
		}

		$event = $this->Events->get($context['data']['event_id']);
		$compareDate = $event[$field];

		switch ($field) {
			case 'from':
				$compare = $compareDate->copy()->subDays(10);
				if (!($date->gte($compare))) {
					return 'You cannot set a date before ' . $compare->format('Y-m-d');
				}
				$compareDate = $event['to'];
				$compare = $compareDate->copy()->addDays(10);
				if (!($date->lte($compare))) {
					return 'You cannot set a date after ' . $compare->format('Y-m-d');
				}
				return true;
			case 'to':
				$compare = $compareDate->copy()->addDays(10);
				$date = $date->copy()->startofDay();
				if (!($date->lte($compare))) {
					return 'You cannot set a date after ' . $compare->format('Y-m-d');
				}
				$compareDate = $event['from'];
				$compare = $compareDate->copy()->subDays(10);
				if (!($date->gte($compare))) {
					return 'You cannot set a date before ' . $compare->format('Y-m-d');
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
		$last = $this->Events->find('first', ['order' => ['from' => 'DESC']]);
		$current = $this->Events->find('first', ['conditions' => ['id !=' => $last['id']], 'order' => ['from' => 'DESC']]);

		$currentAttendees = $this->find('all', ['conditions' => ['Attendees.event_id' => $current['id']]]);
		$currentUserList = Hash::extract($currentAttendees, '{n}.Attendees.user_id');
		$lastAttendees = $this->find('all', ['contain' => ['Users'], 'conditions' => ['Attendees.user_id NOT' => $currentUserList, 'Attendees.event_id' => $last['id']]]);
		return $lastAttendees;
	}

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = [
		'Event' => [
			//'className' => 'Event',
			'foreignKey' => 'event_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		],
		'User' => [
			//'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		]
	];

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
