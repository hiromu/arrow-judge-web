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
$status = json_decode($status, true);
?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Problem ID</th>
			<th>User Name</th>
			<th>Language</th>
			<th>Status</th>
			<th>CPU</th>
			<th>Memory</th>
			<th>Length</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($submissions as $submission): ?>
		<tr>
			<td><?php echo $this->Html->link(h(sprintf('#%d: %s', $submission['Problem']['id'], $submission['Problem']['name'])), '/problems/view/'.$submission['Problem']['id']); ?></td>
			<td><?php echo h($submission['User']['username']); ?></td>
			<td><?php echo h($submission['Language']['name']); ?></td>
			<td><?php echo h($status[$submission['Submission']['status']]); ?></td>
			<td><?php echo h($submission['Submission']['max_cpu']); ?> sec</td>
			<td><?php echo h($submission['Submission']['max_memory']); ?> KB</td>
			<td><?php echo h(mb_strlen($submission['Submission']['source'])); ?> B</td>
			<?php if($submission['User']['id'] == $userid): ?>
			<td><?php echo $this->Html->link('Detail =>', 'detail/'.$submission['Submission']['id']); ?></td>
			<?php else: ?>
			<td></td>
			<?php endif; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
