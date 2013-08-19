<div class="attendees view">
<h2><?php echo __('Attendee'); ?></h2>
<p>
Event: <?php echo h($attendee['Event']['name']); ?>
</p>

<h3><?php echo h($attendee['User']['username']); ?></h3>

<p><?php echo User::statuses($attendee['User']['status']); ?></p>

	<dl>
		<dt><?php echo __('From'); ?></dt>
		<dd>
			<?php echo h($attendee['Attendee']['from']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('To'); ?></dt>
		<dd>
			<?php echo h($attendee['Attendee']['to']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php if (Auth::id()) { ?>
				<?php if ($attendee['Attendee']['display_email'] || Auth::hasRole(Configure::read('Role.admin'))) {; ?>
				<?php echo h($attendee['User']['email']); ?>
				<?php } ?>
			<?php } else { ?>
				<i>You need to be logged in to see the email.</i>
			<?php } ?>
			&nbsp;
		</dd>

		<dt><?php echo __('IRC Nick'); ?></dt>
		<dd>
			<?php echo h($attendee['User']['irc_nick']); ?>
			&nbsp;
		</dd>

		<dt><?php echo __('Comment'); ?></dt>
		<dd>
			<?php echo nl2br(h($attendee['Attendee']['comment'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Back'), array('controller' => 'overview', 'action' => 'index')); ?> </li>
	</ul>
</div>
