<?php
App::uses('Debugger', 'Utility');
if($contest_id) {
	echo $this->Element('contest', array('mode' => 'problem', 'contest_id' => $contest_id));
}
?>
<h1><?php echo h(sprintf('Question for #%d: %s', $question['Problem']['id'], $question['Problem']['name'])); ?></h1>
<table class="table table-striped normal-pre">
	<thead>
		<tr>
			<th>User Name</th>
			<th>Question</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo h($question['User']['username']); ?></td>
			<td><pre><?php echo h($question['Question']['question']); ?></pre></td>
		</tr>
	</tbody>
</table>
<?php
	echo $this->Form->create('Question');
	echo $this->Form->input('answer', array('type' => 'textarea', 'label' => 'Answer', 'rows' => '3'));
	echo $this->Form->input('public', array('type' => 'checkbox', 'label' => array('class' => 'norequire', 'text' => 'Not open to the public'), 'value' => 1));
	echo $this->Form->end('Submit');
?>
