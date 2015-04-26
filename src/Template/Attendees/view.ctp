<div class="attendees view">
<h2><?php echo __('Attendee'); ?></h2>
<p>
Event: <?php echo h($attendee->event['name']); ?>
</p>

<h3><?php echo h($attendee->user['username']); ?></h3>

<p><?php echo App\Model\Entity\User::statuses($attendee->user['status']); ?></p>

	<dl>
		<dt><?php echo __('From'); ?></dt>
		<dd>
			<?php echo h($attendee['from']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('To'); ?></dt>
		<dd>
			<?php echo h($attendee['to']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php if ($this->AuthUser->id()) { ?>
				<?php if ($attendee['display_email'] || $this->AuthUser->hasRole(Cake\Core\Configure::read('Roles.admin'))) {; ?>
				<?php echo h($attendee->user['email']); ?>
				<?php } ?>
			<?php } else { ?>
				<i>You need to be logged in to see the email.</i>
			<?php } ?>
			&nbsp;
		</dd>

		<dt><?php echo __('IRC Nick'); ?></dt>
		<dd>
			<?php echo h($attendee->user['irc_nick']); ?>
			&nbsp;
		</dd>

		<dt><?php echo __('Comment'); ?></dt>
		<dd>
			<?php echo nl2br(h($attendee['comment'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Back'), ['controller' => 'Overview', 'action' => 'index']); ?> </li>
	</ul>
</div>
