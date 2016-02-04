<div class="events index">
	<h2><?php echo __('Events'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('from'); ?></th>
			<th><?php echo $this->Paginator->sort('to'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($events as $event): ?>
	<tr>
		<td><?php echo $this->Time->niceDate($event['from']); ?>&nbsp;</td>
		<td><?php echo $this->Time->niceDate($event['to']); ?>&nbsp;</td>
		<td><?php echo h($event['name']); ?>&nbsp;</td>
		<td><?php echo h($event['description']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), ['action' => 'view', $event['id']]); ?>
			<?php echo $this->Html->link(__('Edit'), ['action' => 'edit', $event['id']]); ?>
			<?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $event['id']], ['confirm' => __('Are you sure you want to delete # {0}?', $event['id'])]); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<?php echo $this->element('Tools.pagination'); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Event'), ['action' => 'add']); ?></li>
		<li><?php echo $this->Html->link(__('Back'), ['controller' => 'Overview', 'action' => 'admin']); ?></li>
	</ul>
</div>
