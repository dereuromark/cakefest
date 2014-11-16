<div class="index">
<div style="float: right; margin-left: 20px;">
<a href="http://cakefest.org/" target="_blank"><img src="http://cakefest.org/img/event.jpg" title="CakeFest" style="margin-bottom: 8px;" alt="" /></a>
</div>

<h2>CakeFest <?php echo $event->from->format('Y'); ?></a> - Who is on board?</h2>
<p><b><?php echo $event->from->format('F jS'); ?> - <?php echo $event->to->format('F jS'); ?></b>, <?php echo h($event->name); ?></p>
<?php if (!empty($event->description)) { ?>
<p>
<?php echo h($event->description); ?>
</p>
<?php } ?>

<h3>What is the CakeFest</h3>
<p>
It's the <a href="http://cakefest.org/" target="_blank">annual conference dedicated to CakePHP</a>.
<br />
Join us now at the awesome meetup of most CakePHP devs.
</p>

<h3>What is this site for</h3>
<p>
We hear it all the time in the IRC channel: "Are you going to the fest?" etc.
<br />
Currently, it is difficult to know from all devs who will be at the conference, and from when to when.
This page helps to set a basic attendance overview. Also, if you allow other people to see your email or provide an IRC nick, you
might be able to connect before, after and especially during the event to socialize, hang out or party :-)
</p>

<h3>The attendees this year</h3>
<p>
Currently, <?php echo count($attendees); ?> devs submitted their attendance schedule so far:
</p>

<?php
echo $this->element('timeline');
?>

</div>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Join in'), array('controller' => 'attendance', 'action' => 'index')); ?></li>
	</ul>
	<?php if (!$this->AuthUser->id()) { ?>
	<br />
	<br />
	<h4>No account yet?</h4>
	<p style="margin-top: 10px;">
	<?php echo $this->Html->link('Please register first', array('controller' => 'account', 'action' => 'register'))?>
	</p>
	<?php } ?>
</div>