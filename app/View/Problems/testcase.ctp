<?php
App::uses('Debugger', 'Utility');
$status = json_decode($status, true);
?>
<h1>Testcase Detail</h1>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Problem ID</th>
			<th>Language</th>
			<th>Status</th>
			<th>CPU Limit</th>
			<th>Memory Limit</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo h(sprintf('#%d: %s', $problem['Problem']['id'], $problem['Problem']['name'])); ?></td>
			<td><?php echo h($problem['Language']['name']); ?></td>
			<td class="status_<?php echo h($problem['Problem']['status']); ?>"><?php echo h($status[$problem['Problem']['status']]); ?></td>
			<td><?php echo h($problem['Problem']['cpu']); ?> sec</td>
			<td><?php echo h($problem['Problem']['memory']); ?> MB</td>
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
