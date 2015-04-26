<div class="users index">

<?php
		echo $this->Form->create(null);
		echo $this->Form->input('search');
		echo $this->Form->input('role_id', [
				'empty' => ' - no filter - '
		]);
		echo $this->Form->input('status', [
				'options' => App\Model\Entity\User::statuses(),
				'empty' => ' - no filter - '
		]);
		echo $this->Form->submit(__('Submit'));
		echo $this->Form->end();
		?>


	<h2><?php echo __('Users'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('username'); ?></th>
			<th><?php echo $this->Paginator->sort('email'); ?></th>
			<?php if (false) { ?>
			<th><?php echo $this->Paginator->sort('timezone'); ?></th>
			<?php } ?>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('role_id'); ?></th>
			<?php if (false) { ?>
			<th><?php echo $this->Paginator->sort('language_id'); ?></th>
			<?php } ?>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($users as $user): ?>
	<tr>
		<td><?php echo h($user['username']); ?>&nbsp;</td>
		<td><?php echo h($user['email']); ?>&nbsp;</td>
		<?php if (false) { ?>
		<td><?php echo h($user['timezone']); ?>&nbsp;</td>
		<?php } ?>
		<td><?php echo $user->statuses($user['status']); ?>&nbsp;</td>
		<td><?php echo h($user['created']); ?>&nbsp;</td>
		<td><?php echo h($user['modified']); ?>&nbsp;</td>
		<td><?php echo $this->Cakefest->roleName($user['role_id']); ?>&nbsp;</td>
		<?php if (false) { ?>
		<td><?php echo h($user['language_id']); ?>&nbsp;</td>
		<?php } ?>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), ['action' => 'view', $user['id']]); ?>
			<?php echo $this->Html->link(__('Edit'), ['action' => 'edit', $user['id']]); ?>
			<?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $user['id']], ['confirm' => __('Are you sure you want to delete # {0}?', $user['id'])]); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<?php echo $this->element('Tools.pagination'); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Back'), ['controller' => 'Overview', 'action' => 'admin']); ?></li>
	</ul>
</div>
