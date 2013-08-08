<div style="float: right; margin-left: 20px;">
<a href="http://cakefest.org/" target="_blank"><img src="http://cakefest.org/img/event.jpg" title="CakeFest" style="margin-bottom: 8px;" alt="" /></a>
</div>

<h2>CakeFest 2013 - Who is on board?</h2>
<p><b>August 29th - September 1st</b>, San Francisco, USA</p>

<h3>What is the CakeFest</h3>
<p>
It's the <a href="http://cakefest.org/" target="_blank">annual conference dedicated to CakePHP</a>.
<br />
Join us now at the awesome meetup of most CakePHP devs.
</p>

<h3>What is this page for</h3>
<p>
Currently, it is difficult to know from all devs who will be at the conference, and from when to when.
This page helps to set a basic attendance overview. Also, if you allow other people to see your email, you
might be able to connect before, after or even during the event and socialize, hang out or party :-)
</p>

<h3>The attendees this year</h3>
<?php
pr($attendees);
?>



<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Join in'), array('controller' => 'attendees', 'action' => 'add')); ?></li>
	</ul>
</div>