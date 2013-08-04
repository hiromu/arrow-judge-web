<?php App::uses('Debugger', 'Utility'); ?>
<h1>Install</h1>
<h2>Directory Permission Status</h2>
<table class="table table-striped">
	<tbody>
		<?php foreach($writable as $directory => $status): ?>
		<tr>
			<td><?php echo h($directory); ?></td>
			<?php if($status): ?>
			<td>OK</td>
			<?php else: ?>
			<td class="error">Not writable</td>
			<?php endif; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php if($ok): ?>
<a class="btn btn-large btn-primary" href="secure">Install</a>
<?php else: ?>
<a class="btn btn-large btn-primary" href="/">Recheck</a>
<?php endif; ?>
