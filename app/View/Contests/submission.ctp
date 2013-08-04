<?php App::uses('Debugger', 'Utility'); ?>
<?php echo $this->Element('contest', array('mode' => 'submission', 'contest_id' => $contest['Contest']['id'])); ?>
<h1>Search Submissions</h1>
<?php echo $this->Element('submission_search', array('problem' => null, 'contest_id' => $contest['Contest']['id'], 'user_id' => $userid)); ?>
<h1>All Submissions</h1>
<?php echo $this->Element('submissions', array('user_hide' => true, 'contest_id' => $contest['Contest']['id'], 'paginate' => true)); ?>
