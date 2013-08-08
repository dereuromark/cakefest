<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Account information'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('username');
		echo $this->Form->input('email');

		echo $this->Form->input('role_id');
		echo $this->Form->input('status', array('options' => User::statuses()));
	?>
	</fieldset>
	<fieldset>
		<legend>Set new password</legend>
	<?php
		echo $this->Form->input('pwd');
		echo $this->Form->input('pwd_repeat');
	?>
	</fieldset>

	<fieldset>
		<legend><?php echo __('Details'); ?></legend>
	<?php
		echo $this->Form->input('irc_nick');
		echo $this->Form->input('timezone');

		echo $this->Form->input('language_id');
	?>
	</fieldset>

<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
	</ul>
</div>
