<?php
App::uses('Debugger', 'Utility');
if($contest_id) {
	echo $this->Element('contest', array('mode' => 'problem', 'contest_id' => $contest_id));
}
?>
<h1><?php echo h(sprintf('#%d: %s', $problem['Problem']['id'], $problem['Problem']['name'])); ?></h1>
<h2>Are you sure to delete this problem?</h2>
<?php
	echo $this->Form->create('Problem');
	echo $this->Form->input('id', array('type' => 'hidden', 'value' => $problem['Problem']['id']));
?>
<div class="submit submit-button">
<?php
	echo $this->Form->submit('Delete', array('div' => false));

	if($contest_id) {
		echo $this->Html->link('Cancel', '/contests/problem/'.$contest_id, array('class' => 'btn btn-large'));
	} else {
		echo $this->Html->link('Cancel', 'index', array('class' => 'btn btn-large'));
	}
?>
</div>
