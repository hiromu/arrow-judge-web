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
<?php echo $this->Element('submissions', array('link_hide' => true, 'contest_id' => null, 'submissions' => array($submission))); ?>
<h2>Testcase <?php echo h(sprintf('#%d', $testcase_id + 1)); ?></h2>
<h3>CPU: <?php echo h(sprintf('%f sec', $cpu)); ?>, Memory: <?php echo h(sprintf('%d KB', $memory)); ?></h3>
<div class="row-fluid">
	<div class="span6">
		<pre><?php echo h($input); ?></pre>
	</div>
	<div class="span6">
		<pre><?php echo h($output); ?></pre>
	</div>
</div>
