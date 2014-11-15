<div class="attendees form">
<?php echo $this->Form->create($attendee); ?>
	<fieldset>
		<legend><?php echo __('Add Attendee'); ?></legend>
	<?php
		echo $this->Form->input('from', array('type' => 'datetime', 'dateFormat' => 'DMY', 'timeFormat' => 24, 'interval' => 30));
		echo $this->Form->input('to', array('type' => 'datetime', 'dateFormat' => 'DMY', 'timeFormat' => 24, 'interval' => 30));
		echo $this->Form->input('display_email', array('after' => ' Only logged in users will be able to see it.'));
		echo $this->Form->input('comment');
		echo $this->Form->input('event_id');
	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit')); ?>
<?php echo $this->Form->end(); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Back'), array('action' => 'index')); ?></li>
	</ul>
</div>
