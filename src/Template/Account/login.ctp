<h2>Welcome</h2>
<p>You need to login to proceed.</p>

<?php echo $this->Form->create('User');?>

<h3>Please enter your username/email and password below.</h3>

	<?php
		echo $this->Form->input('login', array('label' => 'Your username or email'));
		echo $this->Form->input('password', array('autocomplete' => 'off'));
		if (Cake\Core\Configure::read('Config.rememberMe')) {
			echo $this->Form->input('RememberMe.confirm', array('type' => 'checkbox', 'label' => __('Remember me on this device.')));
		}
	?>

<?php echo $this->Form->submit(__('Log me in'));?>
<?php echo $this->Form->end(); ?>

<h3>No account yet?</h3>
<p><?php echo $this->Html->link('Create one here. For free :P', array('action' => 'register'))?></p>

<h3>Password lost?</h3>
<p><?php echo $this->Html->link('Reset your password.', array('action' => 'lost_password'))?></p>

