<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>Admin panel</h2>

<h3>Management</h3>

	<ul>
		<li><?php echo $this->Html->link(__('Events'), ['controller' => 'Events', 'action' => 'index']); ?></li>
		<li><?php echo $this->Html->link(__('Users'), ['controller' => 'Users', 'action' => 'index']); ?></li>
		<li><?php echo $this->Html->link(__('Attendees'), ['controller' => 'Attendees', 'action' => 'index']); ?></li>
	</ul>
