<?php
App::uses('BaseEmailConfig', 'Tools.Config');

class EmailConfig extends BaseEmailConfig {

	public $default = array(
		'host' => '',
		'username' => '',
		'password' => '',
		'template' => 'default',
		'layout' => 'default',
		'transport' => 'Smtp',
		'trace' => false, // Detailed trace log.
		'log' => true // Report log entry.
	);

}
