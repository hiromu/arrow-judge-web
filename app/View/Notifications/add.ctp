<?php App::uses('Debugger', 'Utility'); ?>
<?php echo $this->Element('contest_setting', array('mode' => 'notification', 'contest_id' => $contest_id)); ?>
<h1>Notifications</h1>
<?php
	echo $this->Form->create('Notification');
	echo $this->Form->input('data', array('type' => 'text', 'label' => 'Notification Statement'));
	echo $this->Form->end('Submit');
?>
