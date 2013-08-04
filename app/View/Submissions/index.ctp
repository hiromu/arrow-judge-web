<?php
App::uses('Debugger', 'Utility');
$status = json_decode($status, true);
?>
<h1>Submissions</h1>
<h2>Search Submissions</h2>
<?php echo $this->Element('submission_search', array('contest_id' => null, 'user_id' => null)); ?>
<h2>Latest Submissions</h2>
<?php echo $this->Element('submissions', array('contest_id' => null, 'paginate' => true)); ?>
