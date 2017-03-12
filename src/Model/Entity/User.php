<?php
namespace App\Model\Entity;

/**
 * @property int $id
 * @property string $username
 * @property string $irc_nick
 * @property string $email
 * @property bool $email_confirmed
 * @property string $password
 * @property string $timezone
 * @property int $status
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $role_id
 * @property int $language_id
 *
 * @property \App\Model\Entity\Attendee[] $attendees
 */
class User extends Entity {

	const STATUS_DEV = 0;

	const STATUS_CORE_DEV = 1;

	/**
	 * @param int|null $value
	 * @return mixed
	 */
	public static function statuses($value = null) {
		$array = [
			self::STATUS_DEV => __('CakePHP Developer'),
			self::STATUS_CORE_DEV => __('CakePHP Core Developer'),
		];

		return parent::enum($value, $array);
	}

}
