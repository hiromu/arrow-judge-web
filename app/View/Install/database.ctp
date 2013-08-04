<?php App::uses('Debugger', 'Utility'); ?>
<h1>Install</h1>
<h2>Database Setting</h2>
<?php
	echo $this->Form->create('Database');
	echo $this->Form->input('host', array('type' => 'text', 'label' => 'Database host'));
	echo $this->Form->input('login', array('type' => 'text', 'label' => 'Database user'));
	echo $this->Form->input('password', array('type' => 'password', 'label' => 'Database password'));
	echo $this->Form->input('database', array('type' => 'text', 'label' => 'Database name'));
	echo $this->Form->end('Submit');
?>
