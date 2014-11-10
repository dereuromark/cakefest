<?php
use Cake\Core\Configure;
?>
<h2><?= __d('cake', 'An Internal Error Has Occurred') ?></h2>
<p class="error">
	<strong><?= __d('cake', 'Error') ?>: </strong>
	<?= h($message) ?>
</p>
<?php
if (Configure::read('debug')):
?>
<?php if (!empty($error->queryString)) : ?>
	<p class="notice">
		<strong>SQL Query: </strong>
		<?= h($error->queryString); ?>
	</p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
		<strong>SQL Query Params: </strong>
		<?= Debugger::dump($error->params); ?>
<?php endif; ?>
<?php
	echo $this->element('auto_table_warning');
	echo $this->element('exception_stack_trace');
endif;
?>
