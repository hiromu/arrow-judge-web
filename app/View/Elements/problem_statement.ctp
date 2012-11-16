<?php
	echo $this->Form->create('Problem');
	echo $this->Form->input('name', array('type' => 'text', 'label' => 'Problem Name'));
	echo $this->Form->input('statement', array('type' => 'textarea', 'label' => 'Statement', 'id' => 'statement'));	
	if(!$problem['Problem']['contest_id'] && (!isset($problem['Problem']['public']) || !$problem['Problem']['public'])) {
		echo $this->Form->input('public', array('type' => 'radio', 'label' => 'Public', 'options' => array('0' => 'private', '1' => 'public')));		
	}
?>
<div class="submit submit-button">
<?php
	echo $this->Form->submit('Submit', array('div' => false));
	echo $this->Html->link('Cancel', '/problems', array('class' => 'btn btn-large'));
?>
</div>
<script type="text/javascript">
	tinyMCE.init({
		mode: 'exact',
		elements: 'statement',
	});
</script>
