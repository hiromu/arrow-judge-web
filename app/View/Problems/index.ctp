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
<div class="append">
	<i class="icon-plus-sign"></i>
	<?php echo $this->Html->link('Add new problem', 'create'); ?>
</div>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Problem ID</th>
			<th>Problem Name</th>
			<th>CPU Limit</th>
			<th>Stack Limit</th>
			<th>Memory Limit</th>
			<th>Author</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($problems as $problem): ?>
		<tr>
			<td><?php echo h($problem['Problem']['id']); ?></td>
			<td><?php echo $this->Html->link($problem['Problem']['name'], 'view/'.$problem['Problem']['id']); ?></td>
			<td><?php echo h($problem['Problem']['cpu']); ?> sec</td>
			<td><?php echo h($problem['Problem']['stack']); ?> MB</td>
			<td><?php echo h($problem['Problem']['memory']); ?> MB</td>
			<td><?php echo h($problem['User']['username']); ?></td>
			<?php if($problem['Problem']['user_id'] == $userid): ?>
			<td><?php echo $this->Html->link('Setting =>', 'setting/'.$problem['Problem']['id']); ?></td>
			<?php else: ?>
			<td></td>
			<?php endif; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
