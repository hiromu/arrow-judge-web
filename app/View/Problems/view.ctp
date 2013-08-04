<?php
App::uses('Debugger', 'Utility');
if($contest_id) {
	echo $this->Element('contest', array('mode' => 'problem', 'contest_id' => $contest_id));
}
?>
<h1><?php echo h(sprintf('#%d: %s', $problem['Problem']['id'], $problem['Problem']['name'])); ?></h1>
<h4>CPU Limit</h4>
<div class="statement">
	<p><?php echo h($problem['Problem']['cpu']); ?> sec</p>
</div>
<h4>Memory Limit</h4>
<div class="statement">
	<p><?php echo h($problem['Problem']['memory']); ?> MB</p>
</div>
<h4>Statement</h4>
<div class="statement">
	<p><?php echo $problem['Problem']['statement']; ?></p>
</div>
<h4>Sample Input/Output</h4>
<div class="statement">
<?php for($i = 1; $i < count($sample_inputs); $i++): ?>
<?php if($sample_inputs[$i - 1]): ?>
	<h5>#<?php echo h($i); ?></h5>
	<div class="row-fluid">
		<div class="span6">
			<pre><?php echo h($sample_inputs[$i - 1]); ?></pre>
		</div>
		<div class="span6">
			<pre><?php echo h($sample_outputs[$i - 1]); ?></pre>
		</div>
	</div>
<?php endif; ?>
<?php endfor; ?>
</div>
<div class="submit-button">
<?
	echo $this->Html->link('Submit', '/submissions/submit/'.$problem['Problem']['id'].'/'.$contest_id, array('class' => 'btn btn-primary btn-large'));
	echo $this->Html->link('Question', '/questions/index/'.$problem['Problem']['id'].'/'.$contest_id, array('class' => 'btn btn-large'));
	echo $this->Html->link('Submissions', 'submission/'.$problem['Problem']['id'].'/'.$contest_id, array('class' => 'btn btn-large'));
	if($problem['Problem']['user_id'] == $userid) {
		echo $this->Html->link('Judge Result', 'judge/'.$problem['Problem']['id'].'/'.$contest_id, array('class' => 'btn btn-large'));
	}
?>
</div>
