<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $this->fetch('title'); ?> - CakeFest App
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');

		$this->Html->script('jquery', array('inline' => false));
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<div style="float: right;">
				<?php if ($this->AuthUser->id()) { ?>
					<?php echo h($this->Session->read('Auth.User.username')); ?> [<?php echo h($this->Session->read('Auth.User.email')); ?>] -

					<?php if ($this->AuthUser->hasRole(Configure::read('Role.admin'))) { ?>
						<?php echo $this->Html->link('Admin', array('controller' => 'overview', 'action' => 'admin')); ?> |
					<?php } ?>
					<?php echo $this->Html->link('Account', array('controller' => 'account', 'action' => 'edit')); ?> |
					<?php echo $this->Html->link('Attendance', array('controller' => 'attendance', 'action' => 'index')); ?> |
					<?php echo $this->Html->link('Logout', array('controller' => 'account', 'action' => 'logout')); ?>
				<?php } else { ?>
					<?php echo $this->Html->link('Login', array('controller' => 'account', 'action' => 'login')); ?> |
					<?php echo $this->Html->link('Register', array('controller' => 'account', 'action' => 'register')); ?>
				<?php } ?>
			</div>

			<h1><?php echo $this->Html->link('CakeFest 2014 - The Attendance App', '/'); ?></h1>
		</div>
		<div id="content">

			<?php echo $this->Common->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<div style="float: left; text-align: left;">
<?php
	$url = array(
		'controller' => 'contact',
		'?' => array('subject' => 'CakeFest App')
	);
?>
				<p>
				Created by <a href="http://www.dereuromark.de" target="_blank">dereuromark</a> - August 2013.

				Bugs? Issues? <a href="https://github.com/dereuromark/cakefest" target="_blank">Open a PR/ticket</a> or <?php echo $this->Html->link('contact me', $url)?>.

				</p><p>
				More infos to the event at <a href="http://lanyrd.com/2014/cakefest/" target="_blank">lanyrd.com/2014/cakefest/</a>.</p>
			</div>

			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => '', 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?php echo $this->fetch('script'); ?>
	<?php //echo $this->Js->writeBuffer(array('inline' => true, 'onDomReady' => false)); ?>

<?php
$debug =\Cake\Core\Configure::read('debug');
if ($debug > 0 && \Cake\Core\Plugin::loaded('Setup')) {
	$this->loadHelper('Setup.Debug', $debug);
	echo $this->Debug->show();
}
?>
</body>
</html>
