<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $this->fetch('title'); ?> - CakeFest App
	</title>
	<?php
		echo $this->Html->meta('icon');
	?>
	<?php echo $this->Html->css('cake.generic') ?>

	<?php echo $this->fetch('meta') ?>
	<?php echo $this->fetch('css') ?>
	<?php
		$this->Html->script('jquery', ['inline' => false]);
	?>
	<?php echo $this->fetch('script') ?>
</head>
<body>

	<header>
		<div class="header-title">
		<div id="header">
			<div style="float: right;">
				<?php if ($this->AuthUser->id()) { ?>
					<?php echo h($this->Session->read('Auth.User.username')); ?> [<?php echo h($this->Session->read('Auth.User.email')); ?>] -

					<?php if ($this->AuthUser->hasRole(Cake\Core\Configure::read('Roles.admin'))) { ?>
						<?php echo $this->Html->link('Admin', ['controller' => 'Overview', 'action' => 'admin']); ?> |
					<?php } ?>
					<?php echo $this->Html->link('Account', ['controller' => 'Account', 'action' => 'edit']); ?> |
					<?php echo $this->Html->link('Attendance', ['controller' => 'Attendance', 'action' => 'index']); ?> |
					<?php echo $this->Html->link('Logout', ['controller' => 'Account', 'action' => 'logout']); ?>
				<?php } else { ?>
					<?php echo $this->Html->link('Login', ['controller' => 'Account', 'action' => 'login']); ?> |
					<?php echo $this->Html->link('Register', ['controller' => 'Account', 'action' => 'register']); ?>
				<?php } ?>
			</div>

			<span><?php echo $this->Html->link('CakeFest ' . date('Y') . ' - The Attendance App', '/'); ?></span>
		</div>
		</div>
		</header>
		<div id="container">
			<div id="content">

			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>
			</div>
			<div id="footer">
			<div style="float: left; text-align: left;">
<?php
	$url = [
		'controller' => 'contact',
		'?' => ['subject' => 'CakeFest App']
	];
?>
				<p>
				Written in and running on <b>CakePHP <?php echo Cake\Core\Configure::version(); ?></b>. Created by <a href="http://www.dereuromark.de" target="_blank">dereuromark</a> - August 2013.

				Bugs? Issues? <a href="https://github.com/dereuromark/cakefest" target="_blank">Open a PR/ticket</a> or <?php echo $this->Html->link('contact me', $url)?>.

				</p>
				<?php if (false) { ?>
				<p>
				More infos to the event at <a href="http://lanyrd.com/2015/cakefest/" target="_blank">lanyrd.com/2015/cakefest/</a>.</p>
				<?php } ?>
			</div>

			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', ['alt' => '', 'border' => '0']),
					'http://www.cakephp.org/',
					['target' => '_blank', 'escape' => false]
				);
			?>
		</div>
		<footer>
		</footer>
	</div>
	<?php echo $this->fetch('script'); ?>
	<?php echo $this->Js->writeBuffer(['onDomReady' => false]); ?>

<?php
$debug = Cake\Core\Configure::read('debug');
if ($debug > 0 && Cake\Core\Plugin::loaded('Setup')) {
	//$this->loadHelper('Setup.Debug', $debug);
	//echo $this->Debug->show();
}
?>
</body>
</html>
