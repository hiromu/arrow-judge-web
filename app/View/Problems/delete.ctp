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
if($contest_id) {
	echo $this->Element('contest', array('mode' => 'problem', 'contest_id' => $contest_id));
}
?>
<h1><?php echo h(sprintf('#%d: %s', $problem['Problem']['id'], $problem['Problem']['name'])); ?></h1>
<h2>Are you sure to delete this problem?</h2>
<?
	echo $this->Form->create('Problem');
	echo $this->Form->input('id', array('type' => 'hidden', 'value' => $problem['Problem']['id']));
?>
<div class="submit submit-button">
<?php
	echo $this->Form->submit('Delete', array('div' => false));

	if($contest_id) {
		echo $this->Html->link('Cancel', '/contests/problem/'.$contest_id, array('class' => 'btn btn-large'));
	} else {
		echo $this->Html->link('Cancel', '/problems', array('class' => 'btn btn-large'));
	}
?>
</div>
