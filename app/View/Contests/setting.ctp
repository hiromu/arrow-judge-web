<?php App::uses('Debugger', 'Utility'); ?>
<h1>Contest Settings</h1>
<?php
	echo $this->Form->create('Contest');
	echo $this->Form->input('name', array('type' => 'text', 'label' => 'Contest Name'));
	echo $this->Form->input('start', array('type' => 'datetime', 'label' => 'Start', 'dateFormat' => 'YMD', 'timeFormat' => 24,'monthNames' => false, 'minYear' => date('Y'), 'maxYear' => date('Y') + 3));
	echo $this->Form->input('end', array('type' => 'datetime', 'label' => 'End', 'dateFormat' => 'YMD', 'timeFormat' => 24, 'monthNames' => false, 'minYear' => date('Y'), 'maxYear' => date('Y') + 3));
	echo $this->Form->input('description', array('type' => 'textarea', 'id' => 'description'));
	if($contest['Contest']['public'] == 0) {
		echo $this->Form->input('public', array('type' => 'radio', 'label' => 'Public', 'options' => array('0' => 'private', '1' => 'public')));
	}
	echo $this->Form->end('Submit');
?>
<script type="text/javascript">
	tinyMCE.init({
		mode: 'textareas',
		elements: 'description',
	});
</script>
