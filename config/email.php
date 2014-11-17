<?php

use Tools\Config\BaseEmailConfig;

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
