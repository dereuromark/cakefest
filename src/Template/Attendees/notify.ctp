<div class="attendees form">
<?php echo $this->Form->create($form); ?>
	<fieldset>
		<legend><?php echo __('Notify Attendees'); ?></legend>
	<?php
	foreach ($lastAttendees as $attendee) {
		$label = $attendee->user->username . ' - ' . $attendee->user->email;
		echo $this->Form->input('Form.' . $attendee['id'] . '.check', ['type' => 'checkbox', 'label' => $label]);
		echo $this->Form->hidden('Form.' . $attendee['id'] . '.user_id');
		echo $this->Form->hidden('Form.' . $attendee['id'] . '.email');
		echo $this->Form->hidden('Form.' . $attendee['id'] . '.username');
	}
	if (!count($lastAttendees)) {
		echo '<i>n/a</i>';
	}
	?>
	</fieldset>
	<fieldset>
		<legend>Message</legend>
	<?php
		echo $this->Form->input('subject');
		echo $this->Form->input('message', ['type' => 'textarea']);
	?>
	</fieldset>
	<?php echo $this->Form->submit(__('Send')); ?>
<?php echo $this->Form->end(); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Attendees'), ['action' => 'index']); ?></li>
	</ul>
</div>
