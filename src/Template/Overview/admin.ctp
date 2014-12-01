<h2>Admin panel</h2>

<h3>Management</h3>

	<ul>
		<li><?php echo $this->Html->link(__('Events'), array('controller' => 'Events', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Users'), array('controller' => 'Users', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Attendees'), array('controller' => 'Attendees', 'action' => 'index')); ?></li>
	</ul>
