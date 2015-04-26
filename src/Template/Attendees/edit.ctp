<div class="attendees form">
<?php echo $this->Form->create($attendee); ?>
	<fieldset>
		<legend><?php echo __('Edit Attendee'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('from', ['timeFormat' => 24, 'interval' => 30]);
		echo $this->Form->input('to', ['timeFormat' => 24, 'interval' => 30]);
		echo $this->Form->input('display_email');
		echo $this->Form->input('comment');
		echo $this->Form->input('event_id');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit')); ?>
<?php echo $this->Form->end(); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $attendee->id], ['confirm' => __('Are you sure you want to delete # {0}?', $attendee->id)]); ?></li>
		<li><?php echo $this->Html->link(__('List Attendees'), ['action' => 'index']); ?></li>
	</ul>
</div>
