<div class="attendees index">
	<h2><?php echo __('My Attendance'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('event_id'); ?></th>
			<th><?php echo $this->Paginator->sort('from'); ?></th>
			<th><?php echo $this->Paginator->sort('to'); ?></th>
			<th><?php echo $this->Paginator->sort('display_email'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($attendees as $attendee): ?>
	<tr>
		<td>
			<?php //echo $this->Html->link($attendee['Event']['name'], array('controller' => 'events', 'action' => 'view', $attendee['Event']['id'])); ?>
			<?php echo h($attendee['Event']['name']); ?>
		</td>
		<td><?php echo h($attendee['Attendee']['from']); ?>&nbsp;</td>
		<td><?php echo h($attendee['Attendee']['to']); ?>&nbsp;</td>
		<td><?php echo $this->Format->yesNo($attendee['Attendee']['display_email']); ?>&nbsp;</td>

		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $attendee['Attendee']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $attendee['Attendee']['id']), null, __('Are you sure you want to delete # %s?', $attendee['Attendee']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
	<?php if (empty($attendees)) { ?>
		<li><?php echo $this->Html->link(__('Attend now'), array('action' => 'add')); ?></li>
	<?php } ?>
		<li><?php echo $this->Html->link(__('Back'), array('controller' => 'overview', 'action' => 'index')); ?> </li>
	</ul>
</div>
