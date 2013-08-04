<?php App::uses('Debugger', 'Utility'); ?>
<h1>Reset your password</h1>
<div class="row-fluid">
<?php
	echo $this->Form->create('User');
	echo $this->Form->input('username', array('type' => 'text', 'label' => 'Enter your username or email address'));
	echo $this->Form->end('Submit');
?>
</div>
