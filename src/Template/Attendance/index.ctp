<div class="attendees index">
	<h2><?php echo __('My Attendance'); ?></h2>

<p>as <b><?php echo \App\Model\Entity\User::statuses($user['status'])?></b>.<p>
<?php if ($user['status'] == \App\Model\Entity\User::STATUS_DEV) { ?>
<?php
	$url = [
		'controller' => 'Contact',
		'?' => ['subject' => 'Core Dev', 'message' => 'I am a core dev!']
	];
?>
<p>
If you want to displayed under a different status (as core developer),
<?php echo $this->Html->link('please let me know', $url)?>.
</p>
<?php } ?>

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
			<?php //echo $this->Html->link($attendee->event['name'], array('controller' => 'Events', 'action' => 'view', $attendee->event['id'])); ?>
			<?php echo h($attendee->event['name']); ?>
		</td>
		<td><?php echo $this->Time->nice($attendee['from']); ?>&nbsp;</td>
		<td><?php echo $this->Time->nice($attendee['to']); ?>&nbsp;</td>
		<td><?php echo $this->Format->yesNo($attendee['display_email']); ?>&nbsp;</td>

		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), ['action' => 'edit', $attendee['id']]); ?>
			<?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $attendee['id']], ['confirm' => __('Are you sure you want to delete # {0}?', $attendee['id'])]); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>

	<?php echo $this->element('Tools.pagination'); ?>
</div>

<p>
<b>Note: </b> All times are in the timezone of the event location (in this case CET - Central European Time).
</p>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
	<?php if (!count($attendees)) { ?>
		<li><?php echo $this->Html->link(__('Attend now'), ['action' => 'add']); ?></li>
	<?php } ?>
		<li><?php echo $this->Html->link(__('Back'), ['controller' => 'Overview', 'action' => 'index']); ?> </li>
	</ul>
</div>
