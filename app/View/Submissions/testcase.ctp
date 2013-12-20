<?php
App::uses('Debugger', 'Utility');
$status = json_decode($status, true);
if($contest_id) {
	echo $this->Element('contest', array('mode' => 'submission', 'contest_id' => $contest_id));
}
?>
<h1>Submission Detail</h1>
<?php echo $this->Element('submissions', array('link_hide' => true, 'contest_id' => null, 'submissions' => array($submission))); ?>
<h2>Testcase #<?php echo h($testcase_id + 1); ?></h2>
<h3>CPU: <?php echo h(ceil($cpu * 1000) / 1000); ?> sec, Memory: <?php echo h(ceil($memory / 100) * 100); ?> KB</h3>
<div class="row-fluid">
	<div class="span6">
		<pre><?php echo h($input); ?></pre>
	</div>
	<div class="span6">
		<pre><?php echo h($output); ?></pre>
	</div>
</div>
