Hi <?php echo $user['username']; ?>!

<?php echo $message; ?>


Here you can directly log back in:
<?php echo $this->Url->build(['controller' => 'Attendance', 'action' => 'index'], true);?>


Let the others know if and when you will be there :)