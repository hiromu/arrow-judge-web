<?php App::uses('Debugger', 'Utility'); ?>
<?php echo $this->Element('setting', array('mode' => 'server')); ?>
<h1>Judge Server Settings</h1>
<h2>Are you sure to delete <?php echo h(sprintf('%s (%s)', $server['Server']['hostname'], $server['Server']['address'])); ?>?</h2>
<?
	echo $this->Form->create('Server');
	echo $this->Form->input('id', array('type' => 'hidden', 'value' => $server['Server']['id']));
?>
<div class="submit submit-button">
<?php
	echo $this->Form->submit('Delete', array('div' => false));
	echo $this->Html->link('Cancel', 'index', array('class' => 'btn btn-large'));
?>
</div>
