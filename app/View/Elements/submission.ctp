<?php $status = json_decode($status, true); ?>
<table class="table table-striped">
	<thead>
		<tr>
			<?php if(isset($this->Paginator)): ?>
			<th><?php echo $this->Paginator->sort('problem_id', 'Problem ID'); ?></th>
			<?php if($user_show): ?>
			<th><?php echo $this->Paginator->sort('user_id', 'User Name'); ?></th>
			<?php endif; ?>
			<th><?php echo $this->Paginator->sort('language_id', 'Language'); ?></th>
			<th><?php echo $this->Paginator->sort('status', 'Status'); ?></th>
			<th><?php echo $this->Paginator->sort('max_cpu', 'CPU'); ?></th>
			<th><?php echo $this->Paginator->sort('max_memory', 'Memory'); ?></th>
			<th><?php echo $this->Paginator->sort('length', 'Length'); ?></th>
			<th><?php echo $this->Paginator->sort('created', 'Submission Date'); ?></th>
			<th></th>
			<?php else: ?>
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
			<?php endif; ?>
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
			<td><p class="status_<?php echo h($submission['Submission']['status']); ?>"><?php echo h($status[$submission['Submission']['status']]); ?></p></td>
			<?php if($submission['Submission']['max_cpu'] == -1): ?>
			<td>N/A sec</td>
			<?php else: ?>
			<td><?php echo h($submission['Submission']['max_cpu']); ?> sec</td>
			<?php endif; ?>
			<?php if($submission['Submission']['max_memory'] == -1): ?>
			<td>N/A KB</td>
			<?php else: ?>
			<td><?php echo h($submission['Submission']['max_memory']); ?> KB</td>
			<?php endif; ?>
			<td><?php echo h($submission['Submission']['length']); ?> B</td>
			<td><?php echo h($submission['Submission']['created']); ?></td>
			<?php if($submission['User']['id'] == $userid || $admin): ?>
			<td><?php echo $this->Html->link('Detail =>', '/submissions/detail/'.$submission['Submission']['id'].'/'.$contest_id); ?></td>
			<?php else: ?>
			<td></td>
			<?php endif; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
