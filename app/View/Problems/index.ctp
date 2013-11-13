<?php App::uses('Debugger', 'Utility'); ?>
<h1>Problems</h1>
<div class="append">
	<i class="icon-plus-sign"></i>
	<?php echo $this->Html->link('Add new problem', 'create'); ?>
</div>
<?php if(count($privates) > 0): ?>
<h2>Private Problems</h2>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Problem ID</th>
			<th>Problem Name</th>
			<th>CPU Limit</th>
			<th>Memory Limit</th>
			<th>Author</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($privates as $private): ?>
		<tr>
			<td><?php echo h($private['Problem']['id']); ?></td>
			<td><?php echo $this->Html->link($private['Problem']['name'], 'view/'.$private['Problem']['id']); ?></td>
			<td><?php echo h($private['Problem']['cpu']); ?> sec</td>
			<td><?php echo h($private['Problem']['memory']); ?> MB</td>
			<td><?php echo $this->Html->link($private['User']['username'], '/users/index/'.$private['User']['id']); ?></td>
			<?php if($private['Problem']['user_id'] == $userid): ?>
			<td><?php echo $this->Html->link('Setting =>', 'setting/'.$private['Problem']['id']); ?></td>
			<td><?php echo $this->Html->link('Delete =>', 'delete/'.$private['Problem']['id']); ?></td>
			<?php else: ?>
			<td></td>
			<td></td>
			<?php endif; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<h2>Public Problems</h2>
<?php endif; ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Problem ID</th>
			<th>Problem Name</th>
			<th>CPU Limit</th>
			<th>Memory Limit</th>
			<th>Author</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($publics as $public): ?>
		<tr>
			<td><?php echo h($public['Problem']['id']); ?></td>
			<td><?php echo $this->Html->link($public['Problem']['name'], 'view/'.$public['Problem']['id']); ?></td>
			<td><?php echo h($public['Problem']['cpu']); ?> sec</td>
			<td><?php echo h($public['Problem']['memory']); ?> MB</td>
			<td><?php echo $this->Html->link($public['User']['username'], '/users/index/'.$public['User']['id']); ?></td>
			<?php if($public['Problem']['user_id'] == $userid): ?>
			<td><?php echo $this->Html->link('Setting =>', 'setting/'.$public['Problem']['id']); ?></td>
			<td><?php echo $this->Html->link('Delete =>', 'delete/'.$public['Problem']['id']); ?></td>
			<?php else: ?>
			<td></td>
			<td></td>
			<?php endif; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
