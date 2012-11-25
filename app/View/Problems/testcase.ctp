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
<h1>Testcase Detail</h1>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Problem ID</th>
			<th>Language</th>
			<th>CPU Limit</th>
			<th>Memory Limit</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo h(sprintf('#%d: %s', $problem['Problem']['id'], $problem['Problem']['name'])); ?></td>
			<td><?php echo h($problem['Language']['name']); ?></td>
			<td><?php echo h($problem['Problem']['cpu']); ?> sec</td>
			<td><?php echo h($problem['Problem']['memory']); ?> MB</td>
			<td class="status_<?php echo h($problem['Problem']['status']); ?>"><?php echo h($status[$problem['Problem']['status']]); ?></td>
		</tr>
	</tbody>
</table>
<h2>Testcase <?php echo h(sprintf('#%d', $testcase_id + 1)); ?></h2>
<h3>CPU: <?php echo h(sprintf('%f sec', $cpu)); ?>, Memory: <?php echo h(sprintf('%d KB', $memory)); ?></h3>
<div class="row-fluid">
	<div class="span6">
		<pre><?php echo h($input); ?></pre>
	</div>
	<div class="span6">
		<pre><?php echo h($output); ?></pre>
	</div>
</div>
