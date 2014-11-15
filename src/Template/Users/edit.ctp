<div class="users form">
<?php echo $this->Form->create($user); ?>
	<fieldset>
		<legend><?php echo __('Account information'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('username');
		echo $this->Form->input('email');


		$availableRoles = Cake\Core\Configure::read('Roles');
		$roles = array();
		foreach ($availableRoles as $role => $id) {
			$roles[$id] = $role;
		}
		echo $this->Form->input('role_id', array('options' => $roles));
		echo $this->Form->input('status', array('options' => $user->statuses()));
	?>
	</fieldset>
	<fieldset>
		<legend>Set new password</legend>
	<?php
		echo $this->Form->input('pwd', array('type' => 'password'));
		echo $this->Form->input('pwd_repeat', array('type' => 'password'));
	?>
	</fieldset>

	<fieldset>
		<legend><?php echo __('Details'); ?></legend>
	<?php
		echo $this->Form->input('irc_nick');
		//echo $this->Form->input('timezone');

		//echo $this->Form->input('language_id');
	?>
	</fieldset>

<?php echo $this->Form->submit(__('Submit')); ?>
<?php echo $this->Form->end(); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user->id), array('confirm' => __('Are you sure you want to delete # {0}?', $user->id))); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
	</ul>
</div>
