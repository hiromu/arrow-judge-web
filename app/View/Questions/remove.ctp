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
<h1>Question for <?php echo h(sprintf('#%d: %s', $question['Problem']['id'], $question['Problem']['name'])); ?></h1>
<?php echo $this->Session->flash(); ?>
<table class="table table-striped normal-pre">
	<thead>
		<tr>
			<th>User Name</th>
			<th>Question</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo h($question['User']['username']); ?></td>
			<td><pre><?php echo h($question['Question']['question']); ?></pre></td>
		</tr>
	</tbody>
</table>
<?php echo $this->Form->create('Question'); ?>
<h2>Are you sure to delete?</h2>
<div class="submit submit-button">
<?php
	echo $this->Form->hidden('id', array('value' => $question['Problem']['id']));
	echo $this->Form->submit('Delete', array('div' => false, 'label' => false));
	echo $this->Html->link('Cancel', '/questions/index/'.$question['Problem']['id'], array('class' => 'btn btn-large'));
?>
</div>
<?php echo $this->Form->end(); ?>
