<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo h($title); ?></title>
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
						<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>
						<a class="brand" href="<?php echo $this->Html->url('/', true); ?>"><?php echo h($title); ?></a>
						<div class="nav-collapse">
							<ul class="nav">
								<li><?php echo $this->Html->link('Contests', '/contests'); ?></li>
								<li><?php echo $this->Html->link('Problems', '/problems'); ?></li>
								<li><?php echo $this->Html->link('Submissions', '/submissions'); ?></li>
								<?php if($admin): ?>
								<li><?php echo $this->Html->link('Site Config', '/settings'); ?></li>
								<?php endif; ?>
							</ul>
							<ul class="nav pull-right">
								<?php if($userid && $username): ?>
								<li><p><?php echo $this->Html->link($username, '/users/index/'.$userid); ?></p></li>
								<li class="divider-vertical"></li>
								<li><?php echo $this->Html->link('Settings', '/users/setting'); ?></li>
								<li><?php echo $this->Html->link('Logout', '/users/logout'); ?></li>
								<?php else: ?>
								<li><?php echo $this->Html->link('Register', '/users/register'); ?></li>
								<li><?php echo $this->Html->link('Login', '/users/login'); ?></li>
								<?php endif; ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
