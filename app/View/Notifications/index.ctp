<?php App::uses('Debugger', 'Utility'); ?>
<?php echo $this->Element('contest_setting', array('mode' => 'setting', 'contest_id' => $contest_id)); ?>
<h1>Notifications</h1>
<div class="append">
	<i class="icon-plus-sign"></i>
	<?php echo $this->Html->link('Add new notification', 'add/'.$contest_id); ?>
</div>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Notification</th>
			<th>Date</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($notifications as $notification): ?>
		<tr>
			<td><?php echo h($notification['Notification']['data']); ?></td>
			<td><?php echo h(date('Y/m/d H:i', strtotime($notification['Notification']['created']))); ?></td>
			<td><?php echo $this->Html->link('Delete =>', 'delete/'.$notification['Notification']['id'].'/'.$contest_id); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
