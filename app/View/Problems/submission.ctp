<?php
App::uses('Debugger', 'Utility');
if($contest_id) {
	echo $this->Element('contest', array('mode' => 'submission', 'contest_id' => $contest_id));
}
?>
<h1>Submissions of <?php echo sprintf('#%d: %s', $problem['Problem']['id'], $problem['Problem']['name']); ?></h1>
<h2>Search Submissions</h2>
<?php echo $this->Element('submission_search', array('problem_id' => $problem['Problem']['id'], 'contest_id' => $contest_id)); ?>
<h2>All Submissions</h2>
<?php echo $this->Element('submissions', array('contest_id' => $contest_id, 'paginate' => true)); ?>
