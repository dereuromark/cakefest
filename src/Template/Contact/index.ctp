
<h2><?php echo __('Contact Form');?></h2>
<p>
My email address: <?php echo $this->Format->encodeEmailUrl(Configure::read('Config.adminEmail')); ?></p>

<?php echo $this->Form->create('Contact');?>
	<fieldset>
		<legend><?php echo __('The quickest way to write me an email');?></legend>
	<?php
		echo $this->Form->input('ContactForm.name');
		echo $this->Form->input('ContactForm.email');
		echo $this->Form->input('ContactForm.subject');
		echo $this->Form->input('ContactForm.message', array('type' => 'textarea', 'class'=>'contact', 'rows'=>10, 'label'=>__('Your Message')));

		if (!Auth::id()) {
			echo $this->Captcha->input('ContactForm');
		}

	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit'), array('class'=>'submit'));?>
<?php echo $this->Form->end();?>

