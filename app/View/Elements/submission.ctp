<?php $status = json_decode($status, true); ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Problem ID</th>
			<?php if($user_show): ?>
			<th>User Name</th>
			<?php endif; ?>
			<th>Language</th>
			<th>Status</th>
			<th>CPU</th>
			<th>Memory</th>
			<th>Length</th>
			<th>Submission Date</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($submissions as $submission): ?>
		<tr>
			<td><?php echo $this->Html->link(h(sprintf('#%d: %s', $submission['Problem']['id'], $submission['Problem']['name'])), '/problems/view/'.$submission['Problem']['id']); ?></td>
			<?php if($user_show): ?>
			<td><?php echo $this->Html->link($submission['User']['username'], '/users/index/'.$submission['User']['id']); ?></td>
			<?php endif; ?>
			<td><?php echo h($submission['Language']['name']); ?></td>
			<td><?php echo h($status[$submission['Submission']['status']]); ?></td>
			<td><?php echo h($submission['Submission']['max_cpu']); ?> sec</td>
			<td><?php echo h($submission['Submission']['max_memory']); ?> KB</td>
			<td><?php echo h(mb_strlen($submission['Submission']['source'])); ?> B</td>
			<td><?php echo h($submission['Submission']['created']); ?></td>
			<?php if($submission['User']['id'] == $userid): ?>
			<td><?php echo $this->Html->link('Detail =>', '/submissions/detail/'.$submission['Submission']['id'].'/'.$contest_id); ?></td>
			<?php else: ?>
			<td></td>
			<?php endif; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
