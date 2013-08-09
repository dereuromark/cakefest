<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<div style="float: right;">
				<?php if ($this->Session->read('Auth.User.id')) { ?>
					<?php if (Auth::hasRole(Configure::read('Role.admin'))) { ?>
						<?php echo $this->Html->link('Admin', array('controller' => 'overview', 'action' => 'admin')); ?> |
					<?php } ?>
					<?php echo $this->Html->link('Logout', array('controller' => 'account', 'action' => 'logout')); ?>
				<?php } else { ?>
					<?php echo $this->Html->link('Login', array('controller' => 'account', 'action' => 'login')); ?> |
					<?php echo $this->Html->link('Register', array('controller' => 'account', 'action' => 'register')); ?>
				<?php } ?>
			</div>

			<h1><?php echo $this->Html->link('CakeFest 2013 - The Attendance APP', '/'); ?></h1>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Common->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<div style="float: left">
				Created by <a href="http://www.dereuromark.de" target="_blank">dereuromark</a> - August 2013.
			</div>

			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => '', 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
	<?php echo $this->fetch('script'); ?>
	<?php echo $this->Js->writeBuffer(array('inline' => true)); ?>
</body>
</html>
