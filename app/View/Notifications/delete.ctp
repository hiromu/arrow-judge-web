<?php App::uses('Debugger', 'Utility'); ?>
<?php echo $this->Element('contest_setting', array('mode' => 'notification', 'contest_id' => $contest_id)); ?>
<h1>Notifications</h1>
<h2>Are you sure to delete "<?php echo h($notification['Notification']['data']); ?>"?</h2>
<?php
	echo $this->Form->create('Notification');
	echo $this->Form->input('id', array('type' => 'hidden', 'value' => $notification['Notification']['id']));
?>
<div class="submit submit-button">
<?php
	echo $this->Form->submit('Delete', array('div' => false));
	echo $this->Html->link('Cancel', 'index/'.$contest_id, array('class' => 'btn btn-large'));
?>
</div>
