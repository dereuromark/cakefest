<h2>Admin panel</h2>

<h3>Management</h3>

	<ul>
		<li><?php echo $this->Html->link(__('Events'), array('controller' => 'events', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Users'), array('controller' => 'users', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Attendees'), array('controller' => 'attendees', 'action' => 'index')); ?></li>
	</ul>
