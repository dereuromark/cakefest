<?php

App::uses('AppHelper', 'View/Helper');

class CakefestHelper extends AppHelper {

	/**
	 * CakefestHelper::roleName()
	 *
	 * @param int $roleId
	 * @return string Role name
	 */
	public function roleName($roleId) {
		$roles = Configure::read('Role');
		foreach ($roles as $role => $id) {
			if ($id == $roleId) {
				return h($role);
			}
		}
		return '';
	}

}
