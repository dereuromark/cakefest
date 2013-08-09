<h2>Register</h2>
<p>We don't want SPAM. So we need to verify your account/email.</p>
<p>
Note: Currently we do not send any emails, not even for registration. You will be logged in right away for your
convenience.
</p>

<?php echo $this->Form->create('User');?>

<h3>Create an account</h3>
<fieldset>
	<legend>Required information</legend>

	<?php
		echo $this->Form->input('username', array());
		echo $this->Form->input('email', array());
		echo $this->Form->input('pwd', array());
		echo $this->Form->input('pwd_repeat', array());
	?>
</fieldset>
<?php if (false) { ?>
<fieldset>
	<legend>Optional information</legend>
	<?php
		echo $this->Form->input('timezone', array());
		echo $this->Form->input('irc_nick', array());
	?>
</fieldset>
<?php } ?>

<?php echo $this->Form->end(__('Log me in'));?>

<h3>No account yet?</h3>
<p><?php echo $this->Html->link('Create one here. For free :P', array('action' => 'register'))?></p>

