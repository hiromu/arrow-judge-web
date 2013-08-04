<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Debugger', 'Utility');
?>
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
