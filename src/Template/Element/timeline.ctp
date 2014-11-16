<?php echo $this->Html->script('jquery'); ?>
<?php echo $this->Html->script('timeline/timeline'); ?>
<?php echo $this->Html->css('/js/timeline/timeline'); ?>

<div id="mytimeline">
	<noscript><p>JavaScript is required to view the attendance timeline.</p></noscript>
</div>

<?php
	$this->loadHelper('Tools.Timeline');
	$from = new \DateTime($event['from']);
	$to = new \DateTime($event['to']);

	$settings = array(
		'min' => $from->sub(new \DateInterval('P10D')),
		'max' => $to->add(new \DateInterval('P10D')),
	);
	$this->Timeline->settings($settings);

	foreach ($attendees as $attendee) {
		$content = '';
		if ($attendee->user['status'] == App\Model\Entity\User::STATUS_CORE_DEV) {
			$content .= '<div style="float: right"><small>' . __('Core Dev') . '</small></div>';
		}
		$content .= $this->Html->link($attendee->user->username, array('controller' => 'attendees', 'action' => 'view', $attendee['id']));

		$this->Timeline->addItem(array('start' => $attendee['from'], 'end' => $attendee['to'], 'content' => $content));
	}
	$this->Timeline->finalize();
?>
