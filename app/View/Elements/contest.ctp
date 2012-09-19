<h1>Contest Settings</h1>
<?php echo $this->Session->flash(); ?>
<?php
	echo $this->Form->create('Contest');
	echo $this->Form->input('name', array('type' => 'text', 'label' => 'Contest Name'));
	echo $this->Form->input('admin', array('type' => 'text', 'label' => 'Admin Username', 'div' => 'required'));
	echo $this->Form->input('start', array('type' => 'datetime', 'label' => 'Start', 'dateFormat' => 'YMD', 'timeFormat' => 24,'monthNames' => false, 'minYear' => date('Y'), 'maxYear' => date('Y') + 3));
	echo $this->Form->input('end', array('type' => 'datetime', 'label' => 'End', 'dateFormat' => 'YMD', 'timeFormat' => 24, 'monthNames' => false, 'minYear' => date('Y'), 'maxYear' => date('Y') + 3));
	echo $this->Form->input('description', array('type' => 'textarea', 'id' => 'description'));
	echo $this->Form->end($button);
?>
<script type="text/javascript">
	tinyMCE.init({
		mode: 'textareas',
		elements: 'description',
	});
</script>
