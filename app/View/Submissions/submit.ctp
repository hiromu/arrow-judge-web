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
?>
<h1><?php echo h(sprintf('#%d: %s', $problem['Problem']['id'], $problem['Problem']['name'])); ?></h1>
<?php
	echo $this->Session->flash();
	echo $this->Form->create('Submission');
	echo $this->Form->input('language_id', array('type' => 'select', 'label' => 'Language', 'options' => $lang, 'empty' => false));
	echo $this->Form->input('source', array('type' => 'textarea', 'label' => 'Source', 'id' => 'source', 'rows' => '20'));
	echo $this->Form->end('Submit');
?>
<script type="text/javascript">
	editAreaLoader.init({
		id: 'source',
		toolbar: 'search, go_to_line, |, undo, redo, |, syntax_selection, highlight, reset_highlight, |, help',
		start_highlight: true,
	});
</script>
