<div class="attendees view">
<h2><?php echo __('Attendee'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($attendee['Attendee']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('From'); ?></dt>
		<dd>
			<?php echo h($attendee['Attendee']['from']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('To'); ?></dt>
		<dd>
			<?php echo h($attendee['Attendee']['to']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Email'); ?></dt>
		<dd>
			<?php echo h($attendee['Attendee']['display_email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comment'); ?></dt>
		<dd>
			<?php echo h($attendee['Attendee']['comment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Event'); ?></dt>
		<dd>
			<?php echo $this->Html->link($attendee['Event']['name'], array('controller' => 'events', 'action' => 'view', $attendee['Event']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($attendee['User']['username'], array('controller' => 'users', 'action' => 'view', $attendee['User']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Attendee'), array('action' => 'edit', $attendee['Attendee']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Attendee'), array('action' => 'delete', $attendee['Attendee']['id']), null, __('Are you sure you want to delete # %s?', $attendee['Attendee']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Attendees'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Attendee'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
