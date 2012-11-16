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
<h2>Search Result</h2>
<?php echo $this->Element('submission', array('user_show' => true, 'contest_id' => $contest_id)); ?>
