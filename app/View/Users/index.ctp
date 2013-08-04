<?php App::uses('Debugger', 'Utility'); ?>
<h1>User Profile: <?php echo h($user['User']['username']); ?></h1>
<h2>Search Submissions</h2>
<?php echo $this->Element('submission_search', array('contest_id' => null, 'user_id' => $user['User']['id'])); ?>
<h2>Latest Submissions</h2>
<?php echo $this->Element('submissions', array('user_hide' => true, 'contest_id' => null, 'paginate' => true)); ?>
