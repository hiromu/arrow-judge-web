<?php App::uses('Debugger', 'Utility'); ?>
<h1>User Setting</h1>
<div class="row-fluid">
<?php
	echo $this->Form->create('User');
	echo $this->Form->input('username', array('type' => 'text'));
	echo $this->Form->input('email', array('type' => 'text'));
	echo $this->Form->input('password', array('type' => 'password'));
	echo $this->Form->input('confirm_password', array('type' => 'password'));
	echo $this->Form->input('allow_email', array('type' => 'radio', 'legend' => 'Recieve contest notifications', 'options' => array('1' => 'Yes', '0' => 'No')));
	echo $this->Form->end('Update');
?>
</div>
