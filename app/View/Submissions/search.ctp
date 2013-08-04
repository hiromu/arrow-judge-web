<?php
App::uses('Debugger', 'Utility');
$syntax = json_decode($syntax, true);
$status = json_decode($status, true);
if($contest_id) {
	echo $this->Element('contest', array('mode' => 'submission', 'contest_id' => $contest_id));
}
?>
<?php if(isset($contest)): ?>
<h1>Submissions of <?php echo h($contest['Contest']['name']); ?></h1>
<h2>Search Submissions</h2>
<?php echo $this->Element('submission_search', array('contest_id' => $contest_id, 'user_id' => null)); ?>
<?php elseif(isset($problem)): ?>
<h1>Submissions of <?php echo sprintf('#%d: %s', $problem['Problem']['id'], $problem['Problem']['name']); ?></h1>
<h2>Search Submissions</h2>
<?php echo $this->Element('submission_search', array('contest_id' => $contest_id, 'problem_id' => $problem['Problem']['id'], 'user_id' => null)); ?>
<?php else: ?>
<h1>Submissions</h1>
<h2>Search Submissions</h2>
<?php echo $this->Element('submission_search', array('contest_id' => $contest_id, 'user_id' => null)); ?>
<?php endif; ?>
<?php echo $this->Element('submissions', array('contest_id' => $contest_id, 'paginate' => true)); ?>
