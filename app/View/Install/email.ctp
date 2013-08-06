<?php App::uses('Debugger', 'Utility'); ?>
<h1>Install</h1>
<h2>Email Setting</h2>
<?php
	echo $this->Form->create('Email');
	echo $this->Form->input('host', array('type' => 'text', 'label' => 'SMTP server'));
	echo $this->Form->input('port', array('type' => 'text', 'label' => 'SMTP port'));
	echo $this->Form->input('username', array('type' => 'text', 'label' => 'SMTP username'));
	echo $this->Form->input('password', array('type' => 'password', 'label' => 'SMTP password'));
	echo $this->Form->input('ssl', array('type' => 'checkbox', 'label' => 'Use SSL'));
	echo $this->Form->input('tls', array('type' => 'checkbox', 'label' => 'Use TLS'));
	echo $this->Form->end('Submit');
?>
