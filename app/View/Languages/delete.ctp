<?php App::uses('Debugger', 'Utility'); ?>
<?php echo $this->Element('setting', array('mode' => 'language')); ?>
<h1>Programming Language Settings</h1>
<h2>Are you sure to delete <?php echo h($language['Language']['detail']); ?>?</h2>
<?php
	echo $this->Form->create('Language');
	echo $this->Form->input('id', array('type' => 'hidden', 'value' => $language['Language']['id']));
?>
<div class="submit submit-button">
<?php
	echo $this->Form->submit('Delete', array('div' => false));
	echo $this->Html->link('Cancel', 'index', array('class' => 'btn btn-large'));
?>
</div>
