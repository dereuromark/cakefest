<h2>Register</h2>
<p>We don't want SPAM. So we need to verify your account/email.</p>
<p>
Note: Currently we do not send any emails, not even for registration. You will be logged in right away for your
convenience.
</p>

<?php echo $this->Form->create($user);?>

<h3>Create an account</h3>
<fieldset>
	<legend>Required information</legend>

	<?php
		echo $this->Form->input('username', []);
		echo $this->Form->input('email', []);

		echo $this->Form->input('pwd', ['type' => 'password']);
		echo $this->Form->input('pwd_repeat', ['type' => 'password']);
	?>
</fieldset>
<?php if (false) { ?>
<fieldset>
	<legend>Optional information</legend>
	<?php
		echo $this->Form->input('timezone', []);
		echo $this->Form->input('irc_nick', []);
	?>
</fieldset>
<?php } ?>

<?php echo $this->Form->submit(__('Create account'));?>
<?php echo $this->Form->end(); ?>

<h3>Already an account?</h3>
<p><?php echo $this->Html->link('Log in then :P', ['action' => 'login'])?></p>

