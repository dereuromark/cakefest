<?php echo $this->Html->script('jquery'); ?>
<?php echo $this->Html->script('timeline/timeline'); ?>
<?php echo $this->Html->css('/js/timeline/timeline'); ?>

<div id="mytimeline"></div>

<?php
	$this->loadHelper('Timeline');
	foreach ($attendees as $attendee) {
		$content = $this->Html->link($attendee['User']['username'], array('controller' => 'attendees', 'action' => 'view', $attendee['Attendee']['id']));
		if ($attendee['User']['status'] == User::STATUS_CORE_DEV) {
			$content .= '<br /><small>' . __('Core Dev') . '</small>';
		}

		$this->Timeline->addItem(array('start' => $attendee['Attendee']['from'], 'end' => $attendee['Attendee']['to'], 'content' => $content));
	}
	$this->Timeline->finalize();
?>