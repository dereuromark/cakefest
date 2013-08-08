<div class="cakefestAttendance index">
	<h2><?php echo __('Cakefest Attendance'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('from'); ?></th>
			<th><?php echo $this->Paginator->sort('to'); ?></th>
			<th><?php echo $this->Paginator->sort('display_email'); ?></th>
			<th><?php echo $this->Paginator->sort('comment'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($cakefestAttendance as $cakefestAttendance): ?>
	<tr>
		<td><?php echo h($cakefestAttendance['CakefestAttendance']['id']); ?>&nbsp;</td>
		<td><?php echo h($cakefestAttendance['CakefestAttendance']['from']); ?>&nbsp;</td>
		<td><?php echo h($cakefestAttendance['CakefestAttendance']['to']); ?>&nbsp;</td>
		<td><?php echo h($cakefestAttendance['CakefestAttendance']['display_email']); ?>&nbsp;</td>
		<td><?php echo h($cakefestAttendance['CakefestAttendance']['comment']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($cakefestAttendance['User']['username'], array('controller' => 'users', 'action' => 'view', $cakefestAttendance['User']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $cakefestAttendance['CakefestAttendance']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $cakefestAttendance['CakefestAttendance']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $cakefestAttendance['CakefestAttendance']['id']), null, __('Are you sure you want to delete # %s?', $cakefestAttendance['CakefestAttendance']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Cakefest Attendance'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
