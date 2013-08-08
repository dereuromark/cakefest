<h2>Welcome</h2>
<p>You need to login to proceed.</p>

<?php echo $this->Form->create('User');?>

<h3>Please enter your username and password below.</h3>

	<?php
		echo $this->Form->input('login', array('label' => 'Your username or email'));
		echo $this->Form->input('password', array('autocomplete' => 'off'));
		if (Configure::read('Config.remember_me')) {
			echo $this->Form->input('RememberMe.confirm', array('type' => 'checkbox', 'label' => 'Remember me on this device.'));
		}
	?>

<?php echo $this->Form->end(__('Log me in'));?>

<h3>No account yet?</h3>
<p><?php echo $this->Html->link('Create one here. For free :P', array('action' => 'register'))?></p>

