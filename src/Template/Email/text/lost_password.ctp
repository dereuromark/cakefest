You requested to reset your password.

Please click on the link to confirm your request:
<?php echo $this->Url->build(['controller' => 'Account', 'action' => 'lost_password', $cCode], true);?>


Alternativly, you can also insert the code manually on the website:
<?php echo "\t"; ?>Code: <?php echo "\t"; ?><?php echo $cCode;?>


Note:
If you did not request the password change or don't need to anymore, please disregard the email.
