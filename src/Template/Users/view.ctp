<div class="users view">
<h2><?php echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($user['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Irc Nick'); ?></dt>
		<dd>
			<?php echo h($user['irc_nick']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($user['email']); ?>
			&nbsp;
		</dd>

		<dt><?php echo __('Timezone'); ?></dt>
		<dd>
			<?php echo h($user['timezone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo $user->statuses($user['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($user['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($user['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Role'); ?></dt>
		<dd>
			<?php
				echo $this->Cakefest->roleName($user['role_id']);
			?>
			&nbsp;
		</dd>
		<?php if (false) { ?>
		<dt><?php echo __('Language'); ?></dt>
		<dd>
			<?php echo h($user['language_id']); ?>
			&nbsp;
		</dd>
		<?php } ?>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), ['action' => 'edit', $user['id']]); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user['id']], ['confirm' => __('Are you sure you want to delete # {0}?', $user['id'])]); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), ['action' => 'index']); ?> </li>
	</ul>
</div>
