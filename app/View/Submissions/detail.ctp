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
$syntax = json_decode($syntax, true);
$status = json_decode($status, true);
if($contest_id) {
	echo $this->Element('contest', array('mode' => 'submission', 'contest_id' => $contest_id));
}
?>
<h1>Submission Detail</h1>
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
			<td><?php echo $this->Html->link(h(sprintf('#%d: %s', $submission['Problem']['id'], $submission['Problem']['name'])), '/problems/view/'.$submission['Problem']['id']); ?></td>
			<td><?php echo h($submission['Language']['name']); ?></td>
			<td><?php echo h($submission['Submission']['max_cpu']); ?> sec</td>
			<td><?php echo h($submission['Submission']['max_memory']); ?> MB</td>
			<td><?php echo h($status[$submission['Submission']['status']]); ?></td>
		</tr>
	</tbody>
</table>
<h2>Source Code</h2>
<textarea id="source" rows="<?php echo substr_count($submission['Submission']['source'], "\n") + 1; ?>" readonly="readonly"><?php echo h($submission['Submission']['source']); ?></textarea>
<br />
<?php if($submission['Submission']['status'] == 2): ?>
<h2>Compiler Output</h2>
<pre><?php echo h($submission['Submission']['output']); ?></pre>
<?php elseif($submission['Submission']['status'] == 3 && $submission['Submission']['output']): ?>
<h2>Execution Output<h2>
<pre><?php echo h($submission['Submission']['output']); ?></pre>
<?php else: ?>
<?php if(count($output) > 0): ?>
<h2>Testcases</h2>
<div class="statement">
	<?php for($i = 0; $i < count($output); $i++): ?>
	<h3><?php echo h(sprintf("#%d: CPU %fsec, Memory %dKB", $i, $cpu[$i], $memory[$i])); ?></h3>
	<div class="row-fluid">
		<div class="span6">
			<pre><?php echo h($input[$i]); ?></pre>
		</div>
		<div class="span6">
			<pre><?php echo h($output[$i]); ?></pre>
		</div>
	</div>
	<?php endfor; ?>
<?php endif; ?>
<?php endif; ?>
<script type="text/javascript">
	editAreaLoader.init({
		id: 'source',
		is_editable: false,
		start_highlight: true,
		syntax: "<?php echo h($syntax[$submission['Language']['name']]); ?>"
	});
<?php if($submission['Submission']['status'] == 0): ?>
	setInterval('location.reload()', 5000);
<?php endif; ?>
</script>
