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
<h1>Register to <?php echo h($contest['Contest']['name']); ?></h1>
<?php echo $this->Session->flash(); ?>
<table class="table table-striped normal-pre">
	<thead>
		<tr>
			<th>Contest Name</th>
			<th>Contest Admin</th>
			<th>Start</th>
			<th>End</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo h($contest['Contest']['name']); ?></td>
			<td><?php echo h($contest['User']['username']); ?></td>
			<td><?php echo h($contest['Contest']['start']); ?></td>
			<td><?php echo h($contest['Contest']['end']); ?></td>
		</tr>
	</tbody>
</table>
<label>Description</label>
<div class="statement">
<?php echo $contest['Contest']['description']; ?>
</div>
<?php echo $this->Form->create('Registration'); ?>
<div class="submit submit-button">
<?php
	echo $this->Form->hidden('id', array('value' => $contest['Contest']['id']));
	echo $this->Form->submit('Register', array('div' => false, 'label' => false));
	echo $this->Html->link('Cancel', 'index', array('class' => 'btn btn-large'));
?>
</div>
<?php echo $this->Form->end(); ?>
