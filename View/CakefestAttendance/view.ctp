<div class="cakefestAttendance view">
<h2><?php echo __('Cakefest Attendance'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($cakefestAttendance['CakefestAttendance']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('From'); ?></dt>
		<dd>
			<?php echo h($cakefestAttendance['CakefestAttendance']['from']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('To'); ?></dt>
		<dd>
			<?php echo h($cakefestAttendance['CakefestAttendance']['to']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Email'); ?></dt>
		<dd>
			<?php echo h($cakefestAttendance['CakefestAttendance']['display_email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comment'); ?></dt>
		<dd>
			<?php echo h($cakefestAttendance['CakefestAttendance']['comment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($cakefestAttendance['User']['username'], array('controller' => 'users', 'action' => 'view', $cakefestAttendance['User']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Cakefest Attendance'), array('action' => 'edit', $cakefestAttendance['CakefestAttendance']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Cakefest Attendance'), array('action' => 'delete', $cakefestAttendance['CakefestAttendance']['id']), null, __('Are you sure you want to delete # %s?', $cakefestAttendance['CakefestAttendance']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Cakefest Attendance'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cakefest Attendance'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
