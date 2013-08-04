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
<h2>Create Administrative Account</h2>
<div class="row-fluid">
<?php
	echo $this->Form->create('User');
	echo $this->Form->input('username', array('type' => 'text'));
	echo $this->Form->input('email', array('type' => 'text'));
	echo $this->Form->input('password', array('type' => 'password'));
	echo $this->Form->input('confirm_password', array('type' => 'password'));
	echo $this->Form->input('allow_email', array('type' => 'radio', 'legend' => 'Recieve contest notifications', 'options' => array('1' => 'Yes', '0' => 'No')));
	echo $this->Form->end('Create');
?>
</div>