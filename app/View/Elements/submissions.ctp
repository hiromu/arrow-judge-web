<?php $status = json_decode($status, true); ?>
<?php if(isset($paginate) && $paginate && $this->Paginator->numbers()): ?>
<div class="paginate">
<?php echo $this->Paginator->prev('« Prev', null, null, array('class' => 'disabled')); ?>
<?php echo $this->Paginator->numbers(); ?>
<?php echo $this->Paginator->next('Next »', null, null, array('class' => 'disabled')); ?>
</div>
<?php endif; ?>
<table class="table table-striped">
	<thead>
		<tr>
			<?php if(isset($paginate) && $paginate): ?>
			<th><?php echo $this->Paginator->sort('problem_id', 'Problem ID'); ?></th>
			<?php if(!isset($user_hide) || !$user_hide): ?>
			<th><?php echo $this->Paginator->sort('user_id', 'User Name'); ?></th>
			<?php endif; ?>
			<th><?php echo $this->Paginator->sort('language_id', 'Language'); ?></th>
			<th><?php echo $this->Paginator->sort('status', 'Status'); ?></th>
			<th><?php echo $this->Paginator->sort('max_cpu', 'CPU'); ?></th>
			<th><?php echo $this->Paginator->sort('max_memory', 'Memory'); ?></th>
			<th><?php echo $this->Paginator->sort('length', 'Length'); ?></th>
			<th><?php echo $this->Paginator->sort('created', 'Submission Date'); ?></th>
			<?php if(!isset($link_hide) || !$link_hide): ?>
			<th></th>
			<?php endif; ?>
			<?php else: ?>
			<th>Problem ID</th>
			<?php if(!isset($user_hide) || !$user_hide): ?>
			<th>User Name</th>
			<?php endif; ?>
			<th>Language</th>
			<th>Status</th>
			<th>CPU</th>
			<th>Memory</th>
			<th>Length</th>
			<th>Submission Date</th>
			<?php if(!isset($link_hide) || !$link_hide): ?>
			<th></th>
			<?php endif; ?>
			<?php endif; ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach($submissions as $submission): ?>
		<tr>
			<td><?php echo $this->Html->link(h(sprintf('#%d: %s', $submission['Problem']['id'], $submission['Problem']['name'])), '/problems/view/'.$submission['Problem']['id']); ?></td>
			<?php if(!isset($user_hide) || !$user_hide): ?>
			<td><?php echo $this->Html->link($submission['User']['username'], '/users/index/'.$submission['User']['id']); ?></td>
			<?php endif; ?>
			<td><?php echo h($submission['Language']['name']); ?></td>
			<td class="status_<?php echo h($submission['Submission']['status']); ?>"><?php echo h($status[$submission['Submission']['status']]); ?></td>
			<?php if($submission['Submission']['max_cpu'] == -1): ?>
			<td>N/A sec</td>
			<?php else: ?>
			<td><?php echo h(ceil($submission['Submission']['max_cpu'] * 1000) / 1000); ?> sec</td>
			<?php endif; ?>
			<?php if($submission['Submission']['max_memory'] == -1): ?>
			<td>N/A KB</td>
			<?php else: ?>
			<td><?php echo h(ceil($submission['Submission']['max_memory'] / 100) * 100); ?> KB</td>
			<?php endif; ?>
			<td><?php echo h($submission['Submission']['length']); ?> B</td>
			<td><?php echo h($submission['Submission']['created']); ?></td>
			<?php if(!isset($link_hide) || !$link_hide): ?>
			<td><?php echo $this->Html->link('Detail =>', '/submissions/detail/'.$submission['Submission']['id'].'/'.$contest_id); ?></td>
			<?php endif; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php if(isset($paginate) && $paginate && $this->Paginator->numbers()): ?>
<div class="paginate">
<?php echo $this->Paginator->prev('« Prev', null, null, array('class' => 'disabled')); ?>
<?php echo $this->Paginator->numbers(); ?>
<?php echo $this->Paginator->next('Next »', null, null, array('class' => 'disabled')); ?>
</div>
<?php endif; ?>
