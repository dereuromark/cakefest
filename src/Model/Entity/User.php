<?php
namespace App\Model\Entity;

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
