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
if($contest_id) {
	echo $this->Element('contest', array('mode' => 'submission', 'contest_id' => $contest_id));
}
?>
<h1>Submissions of <?php echo sprintf('#%d: %s', $problem['Problem']['id'], $problem['Problem']['name']); ?></h1>
<h2>Search Submissions</h2>
<?php echo $this->Element('submission_search', array('problem_id' => $problem['Problem']['id'], 'contest_id' => $contest_id)); ?>
<h2>All Submissions</h2>
<div class="paginate">
	<?php
		if($this->Paginator->numbers()) {
			echo $this->Paginator->prev('« Prev', null, null, array('class' => 'disabled'));
			echo $this->Paginator->numbers();
			echo $this->Paginator->next('Next »', null, null, array('class' => 'disabled'));
		}
	?>
</div>
<?php echo $this->Element('submission', array('user_show' => true, 'contest_id' => $contest_id)); ?>
