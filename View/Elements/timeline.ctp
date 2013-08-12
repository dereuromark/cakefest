<?php echo $this->Html->script('jquery'); ?>
<?php echo $this->Html->script('timeline/timeline'); ?>
<?php echo $this->Html->css('/js/timeline/timeline'); ?>

<div id="mytimeline"></div>

<?php
	$this->loadHelper('Timeline');
	$settings = array(
		'min' => new DateTime('2013-08-18'),
		'max' => new DateTime('2013-09-13'),
	);
	$this->Timeline->settings($settings);

	foreach ($attendees as $attendee) {
		$content = $this->Html->link($attendee['User']['username'], array('controller' => 'attendees', 'action' => 'view', $attendee['Attendee']['id']));
		if ($attendee['User']['status'] == User::STATUS_CORE_DEV) {
			$content .= '<br /><small>' . __('Core Dev') . '</small>';
		}

		$this->Timeline->addItem(array('start' => new DateTime($attendee['Attendee']['from']), 'end' => new DateTime($attendee['Attendee']['to']), 'content' => $content));
	}
	$this->Timeline->finalize();
?>