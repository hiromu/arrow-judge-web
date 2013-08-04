<?php App::uses('Debugger', 'Utility'); ?>
<h1>Login</h1>
<?php echo $this->Session->flash('auth'); ?>
<div class="row-fluid">
	<div class="login span6">
	<?php
		echo $this->Form->create('User');
		echo $this->Form->input('username', array('type' => 'text'));
		echo $this->Form->input('password');
		echo $this->Form->end('Login');
	?>
	</div>
	<div class="span6">
		<div class="well">
			<h3>Don't you have an account?</h3>
			<?php echo $this->Html->link('Create an account', 'register', array('class' => 'btn')); ?>
		</div>
		<div class="well">
			<h3>Forget password?</h3>
			<?php echo $this->Html->link('Reset your password', 'request', array('class' => 'btn')); ?>
		</div>
	</div>
</div>
