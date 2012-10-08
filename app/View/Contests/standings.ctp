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
echo $this->Element('contest', array('mode' => 'standings', 'contest_id' => $contest['Contest']['id']));
?>
<h1>Standings of <?php echo h($contest['Contest']['name']); ?></h1>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Username</th>
			<?php for($i = 0; $i < count($contest['Problem']); $i++): ?>
			<th><?php echo $this->Html->link(sprintf('#%04d', $i + 1), '/problems/view/'.$contest['Problem'][$i]['id'].'/'.$contest['Contest']['id']); ?></th>
			<?php endfor; ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach($registration as $result): ?>
		<tr>
			<td><?php echo $this->Html->link($result['User']['username'], '/users/index/'.$result['User']['id']); ?></td>
			<?php $solve = json_decode($result['Registration']['score']); ?>
			<?php for($i = 0; $i < count($contest['Problem']); $i++): ?>
			<?php if($solve[$i] == ''): ?>
			<td>-</td>
			<?php else: ?>
			<td><?php echo h('SOLVED'); ?></td>
			<?php endif; ?>
			<?php endfor; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
