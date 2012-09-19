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
<h1>Settings</h1>
<?php echo $this->Session->flash(); ?>
<div class="row-fluid">
<?php
	echo $this->Form->create('Setting');
	echo $this->Form->input('title', array('type' => 'text', 'label' => 'Name of this site'));
	echo $this->Form->input('top_page', array('type' => 'textarea', 'label' => 'Contents of top page', 'id' => 'top_page'));
	echo $this->Form->input('email_address', array('type' => 'text', 'label' => 'Email address for sending email'));
	echo $this->Form->end('Submit');
?>
</div>
<script type="text/javascript">
	tinyMCE.init({
		mode: 'exact',
		elements: 'top_page',
	});
</script>
