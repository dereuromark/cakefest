<?php
namespace App\Model\Entity;

use App\Model\Entity\AppEntity;

class User extends AppEntity {

	const STATUS_DEV = 0;

	const STATUS_CORE_DEV = 1;

	/**
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
