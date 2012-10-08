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
echo $this->Element('contest', array('mode' => 'submission', 'contest_id' => $contest['Contest']['id']));
?>
<h1>Search Submissions</h1>
<?php echo $this->Element('submission_search', array('problem' => null, 'contest_id' => $contest['Contest']['id'], 'user_id' => $userid)); ?>
<h1>All Submissions</h1>
<?php echo $this->Element('submission', array('user_show' => false, 'contest_id' => $contest['Contest']['id'])); ?>
