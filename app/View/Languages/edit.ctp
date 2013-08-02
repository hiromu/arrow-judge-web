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
echo $this->Element('setting', array('mode' => 'language'));
?>
<h1>Programming Lanuage Settings</h1>
<?php
	echo $this->Form->create('Language');
	echo $this->Form->input('name', array('type' => 'text', 'label' => 'Language name'));
	echo $this->Form->input('detail', array('type' => 'text', 'label' => 'Short description of the language', 'id' => 'top_page'));
	echo $this->Form->input('extension', array('type' => 'text', 'label' => 'Extension for the language'));
	echo $this->Form->input('coloring', array('type' => 'select', 'options' => $coloring));
	echo $this->Form->input('compile', array('type' => 'text', 'label' => 'Compile command'));
	echo $this->Form->input('execute', array('type' => 'text', 'label' => 'Execute command'));
?>
<div class="submit submit-button">
<?php
	echo $this->Form->submit('Submit', array('div' => false));
	echo $this->Html->link('Cancel', 'index', array('class' => 'btn btn-large'));
?>
</div>
