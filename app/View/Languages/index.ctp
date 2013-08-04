<?php App::uses('Debugger', 'Utility'); ?>
<?php echo $this->Element('setting', array('mode' => 'language')); ?>
<h1>Programming Language Settings</h1>
<div class="append">
	<i class="icon-plus-sign"></i>
	<?php echo $this->Html->link('Add new language', 'create'); ?>
</div>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Description</th>
			<th>extension</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($languages as $language): ?>
		<tr>
			<td><?php echo h($language['Language']['name']); ?></td>
			<td><?php echo h($language['Language']['detail']); ?></td>
			<td><?php echo h($language['Language']['extension']); ?></td>
			<td><?php echo $this->Html->link('Edit =>', 'edit/'.$language['Language']['id']); ?></td>
			<td><?php echo $this->Html->link('Delete =>', 'delete/'.$language['Language']['id']); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
