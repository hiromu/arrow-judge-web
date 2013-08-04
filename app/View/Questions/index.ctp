<?php
App::uses('Debugger', 'Utility');
if($contest_id) {
	echo $this->Element('contest', array('mode' => 'problem', 'contest_id' => $contest_id));
}
?>
<?php if($problem['Problem']['user_id'] != $userid && $userid): ?>
<h1><?php echo h(sprintf('Question for #%d: %s', $problem['Problem']['id'], $problem['Problem']['name'])); ?></h1>
<?php
	echo $this->Form->create('Question');
	echo $this->Form->input('question', array('type' => 'textarea', 'label' => 'Question', 'rows' => '3'));
	echo $this->Form->end('Submit');
?>
<?php endif; ?>
<?php if(count($unanswered) > 0): ?>
<h1>Unanswered Questions</h1>
<table class="table table-striped normal-pre">
	<thead>
		<tr>
			<th>User Name</th>
			<th>Question</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($unanswered as $question): ?>
		<tr>
			<td><?php echo $this->Html->link($question['User']['username'], '/users/index/'.$question['User']['id']); ?></td>
			<td><pre><?php echo h($question['Question']['question']); ?></pre></td>
			<?php if($question['Problem']['user_id'] == $userid || $admin): ?>
			<td><?php echo $this->Html->link('Answer =>', 'answer/'.$question['Question']['id']); ?></td>
			<td><?php echo $this->Html->link('Delete =>', 'remove/'.$question['Question']['id']); ?></td>
			<?php else: ?>
			<td></td>
			<td></td>
			<?php endif; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>
<h1>Questions</h1>
<table class="table table-striped normal-pre">
	<thead>
		<tr>
			<th>User Name</th>
			<th>Question</th>
			<th>Answer</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($questions as $question): ?>
		<tr>
			<td><?php echo $this->Html->link($question['User']['username'], '/users/index/'.$question['User']['id']); ?></td>
			<td><pre><?php echo h($question['Question']['question']); ?></pre></td>
			<td><pre><?php echo h($question['Question']['answer']); ?></pre></td>
			<?php if($question['Question']['public'] == 0): ?>
			<td>Public</td>
			<?php elseif($question['Question']['public'] == 1): ?>
			<td>Private</td>
			<?php endif; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
