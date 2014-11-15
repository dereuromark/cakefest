<?php

namespace App\View\Helper;

use App\View\Helper\AppHelper;
use Cake\Core\Configure;

class CakefestHelper extends AppHelper {

	/**
	 * CakefestHelper::roleName()
	 *
	 * @param int $roleId
	 * @return string Role name
	 */
	public function roleName($roleId) {
		$roles = Configure::read('Roles');
		foreach ($roles as $role => $id) {
			if ($id == $roleId) {
				return h($role);
			}
		}
		return '';
	}

}
