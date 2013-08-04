<?php App::uses('Debugger', 'Utility'); ?>
<h1>Register to <?php echo h($contest['Contest']['name']); ?></h1>
<table class="table table-striped normal-pre">
	<thead>
		<tr>
			<th>Contest Name</th>
			<th>Contest Admin</th>
			<th>Start</th>
			<th>End</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo h($contest['Contest']['name']); ?></td>
			<td><?php echo h($contest['User']['username']); ?></td>
			<td><?php echo h($contest['Contest']['start']); ?></td>
			<td><?php echo h($contest['Contest']['end']); ?></td>
		</tr>
	</tbody>
</table>
<label>Description</label>
<div class="statement">
<?php echo $contest['Contest']['description']; ?>
</div>
<?php echo $this->Form->create('Registration'); ?>
<div class="submit submit-button">
<?php
	echo $this->Form->hidden('id', array('value' => $contest['Contest']['id']));
	echo $this->Form->submit('Register', array('div' => false, 'label' => false));
	echo $this->Html->link('Cancel', 'index', array('class' => 'btn btn-large'));
?>
</div>
<?php echo $this->Form->end(); ?>
