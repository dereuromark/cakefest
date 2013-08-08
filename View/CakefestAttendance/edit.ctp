<div class="cakefestAttendance form">
<?php echo $this->Form->create('CakefestAttendance'); ?>
	<fieldset>
		<legend><?php echo __('Edit Cakefest Attendance'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('from');
		echo $this->Form->input('to');
		echo $this->Form->input('display_email');
		echo $this->Form->input('comment');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('CakefestAttendance.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('CakefestAttendance.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Cakefest Attendance'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
