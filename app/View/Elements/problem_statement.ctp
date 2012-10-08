<?php
	echo $this->Form->input('name', array('type' => 'text', 'label' => 'Problem Name'));
	echo $this->Form->input('statement', array('type' => 'textarea', 'label' => 'Statement', 'id' => 'statement'));	
	if(!$problem['Problem']['contest_id']) {
		echo $this->Form->input('public', array('type' => 'radio', 'label' => 'Public', 'options' => array('0' => 'private', '1' => 'public')));		
	}
?>
<script type="text/javascript">
	tinyMCE.init({
		mode: 'exact',
		elements: 'statement',
	});
</script>
