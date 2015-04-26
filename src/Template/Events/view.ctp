<div class="events view">
<h2><?php echo __('Event'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($event['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('From'); ?></dt>
		<dd>
			<?php echo h($event['from']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('To'); ?></dt>
		<dd>
			<?php echo h($event['to']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($event['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($event['description']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Event'), ['action' => 'edit', $event['id']]); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Event'), ['action' => 'delete', $event['id']], ['confirm' => __('Are you sure you want to delete # {0}?', $event['id'])]); ?> </li>
		<li><?php echo $this->Html->link(__('List Events'), ['action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), ['action' => 'add']); ?> </li>
	</ul>
</div>

