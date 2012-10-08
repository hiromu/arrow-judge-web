<pre>
<?php
	echo $this->Form->create('Submission', array('controller' => 'Submission', 'action' => 'search', 'url' => array($contest_id), 'class' => 'form-inline'));
	if(isset($problem_suggest)) {
		echo $this->Form->input('problem', array('type' => 'select', 'label' => 'Problem', 'options' => $problem_suggest, 'div' => false, 'empty' => '-'));
	} else if(isset($problem_id)) {
		echo $this->Form->input('problem', array('type' => 'hidden', 'value' => $problem_id, 'div' => false));
	}
	if(isset($user_id)) {
		echo $this->Form->input('user', array('type' => 'hidden', 'value' => $user_id, 'div' => false));
	}
	echo $this->Form->input('language', array('type' => 'select', 'label' => 'Language', 'options' => $lang, 'div' => false, 'empty' => '-'));
	echo $this->Form->input('status', array('type' => 'select', 'label' => 'Status', 'options' => json_decode($status, true), 'div' => false, 'empty' => '-'));
	echo $this->Form->end(array('value' => 'Submit', 'div' => false, 'class' => 'btn-primary'));
?>
</pre>
