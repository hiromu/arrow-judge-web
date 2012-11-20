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
			<td><?php echo h($submission['Submission']['max_memory']); ?> KB</td>
			<td><?php echo h($status[$submission['Submission']['status']]); ?></td>
		</tr>
	</tbody>
</table>
<h2>Source Code</h2>
<textarea id="source" rows="<?php echo substr_count($submission['Submission']['source'], "\n") + 1; ?>" readonly="readonly"><?php echo h($submission['Submission']['source']); ?></textarea>
<br />
<?php if($submission['Submission']['status'] == 2): ?>
<h2>Compiler Output</h2>
<pre><?php echo h($submission['Submission']['error']); ?></pre>
<?php elseif($submission['Submission']['status'] == 3 && $submission['Submission']['error']): ?>
<h2>Execution Output<h2>
<pre><?php echo h($submission['Submission']['error']); ?></pre>
<?php elseif($submission['Submission']['status'] > 3): ?>
<?php if(count($cpu) > 0): ?>
<h2>Testcases</h2>
<div class="statement">
	<table>
		<tr>
			<th>Testcase</th>
			<th>CPU</th>
			<th>Memory</th>
			<th></th>
		</tr>
		<?php for($i = 0; $i < count($cpu); $i++): ?>
		<tr>
			<td><?php echo h(sprintf('#%d', $i + 1)); ?></td>
			<td><?php echo h(sprintf('%f sec', $cpu[$i])); ?></td>
			<td><?php echo h(sprintf('%d KB', $memory[$i])); ?></td>
			<td><?php echo $this->Html->link('Show =>', 'testcase/'.$submission['Submission']['id'].'/'.($i + 1).'/'.$contest_id); ?>
		</tr>
		<?php endfor; ?>
	</table>
<?php endif; ?>
<?php endif; ?>
<script type="text/javascript">
	function load_callback() {
		var edit_area = $('#frame_source').contents();
		var height = edit_area.find('#container').height();
		edit_area.find('#result').height(height);
		$('#frame_source').height(height + 5);
	}
	editAreaLoader.init({
		id: 'source',
		is_editable: false,
		start_highlight: true,
		syntax: "<?php echo h($submission['Language']['coloring']); ?>",
		EA_load_callback: 'load_callback',
		EA_toggle_on_callback: 'load_callback'
	});
<?php if($submission['Submission']['status'] < 2): ?>
	setInterval('location.reload()', 3000);
<?php endif; ?>
</script>
