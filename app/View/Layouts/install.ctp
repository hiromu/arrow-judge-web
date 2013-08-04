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
 * @copyright		 Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link					http://cakephp.org CakePHP(tm) Project
 * @package			 Cake.View.Layouts
 * @since				 CakePHP(tm) v 0.10.0.1076
 * @license			 MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>Arrow Judge: Install</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('generic');
		echo $this->Html->css('bootstrap/bootstrap');

		echo $this->Html->script('jquery/jquery');
		echo $this->Html->script('jquery/jquery-ui');
		echo $this->Html->script('bootstrap/bootstrap');
		echo $this->Html->script('tiny_mce/tiny_mce');
		echo $this->Html->script('edit_area/edit_area_full');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<div class="navbar navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<span class="brand">Arrow Judge</span>
					</div>
				</div>
			</div>
		</div>
		<div id="content">
			<div id="install">
				<?php echo $this->Session->flash(); ?>
				<?php echo $this->fetch('content'); ?>
			</div>
		</div>
		<div id="footer">
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
