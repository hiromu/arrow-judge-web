<?php App::uses('Debugger', 'Utility'); ?>
<?php echo $this->Element('setting', array('mode' => 'server')); ?>
<h1>Judge Server Settings</h1>
<h2>Disabled Server</h2>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Hostname</th>
			<th>IP Address</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($deny as $server): ?>
		<tr>
			<td><?php echo h($server['Server']['hostname']); ?></td>
			<td><?php echo h($server['Server']['address']); ?></td>
			<td><?php echo $this->Html->link('Enable =>', 'enable/'.$server['Server']['id']); ?></td>
			<td><?php echo $this->Html->link('Delete =>', 'delete/'.$server['Server']['id']); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<h2>Enabled Server</h2>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Hostname</th>
			<th>IP Address</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($allow as $server): ?>
		<tr>
			<td><?php echo h($server['Server']['hostname']); ?></td>
			<td><?php echo h($server['Server']['address']); ?></td>
			<td><?php echo $this->Html->link('Disable =>', 'disable/'.$server['Server']['id']); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
