<div class="attendees index">
	<h2><?php echo __('Attendees'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('from'); ?></th>
			<th><?php echo $this->Paginator->sort('to'); ?></th>
			<th><?php echo $this->Paginator->sort('display_email'); ?></th>
			<th><?php echo $this->Paginator->sort('comment'); ?></th>
			<th><?php echo $this->Paginator->sort('event_id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($attendees as $attendee): ?>
	<tr>
		<td><?php echo h($attendee['from']); ?>&nbsp;</td>
		<td><?php echo h($attendee['to']); ?>&nbsp;</td>
		<td><?php echo $this->Format->yesNo($attendee['display_email']); ?>&nbsp;</td>
		<td><?php echo $this->Format->yesNo(!empty($attendee['comment'])); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($attendee->event['name'], ['controller' => 'events', 'action' => 'view', $attendee->event['id']]); ?>
		</td>
		<td>
			<?php echo $this->Html->link($attendee->user['username'], ['controller' => 'users', 'action' => 'view', $attendee->user['id']]); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), ['action' => 'view', $attendee['id']]); ?>
			<?php echo $this->Html->link(__('Edit'), ['action' => 'edit', $attendee['id']]); ?>
			<?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $attendee['id']], ['confirm' => __('Are you sure you want to delete # {0}?', $attendee['id'])]); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<?php echo $this->element('Tools.pagination'); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Events'), ['controller' => 'Events', 'action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']); ?> </li>
	</ul>
</div>
