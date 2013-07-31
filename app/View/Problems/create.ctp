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
	echo $this->Element('contest', array('mode' => 'problem', 'contest_id' => $contest_id));
}
?>
<div class="append progress progress-striped active">
	<div class="bar" style="width: 25%;">
		<p>25%</p>
	</div>
</div>
<h1>Create Problem</h1>
<?php echo $this->element('problem_statement'); ?>
