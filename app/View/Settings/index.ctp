<?php App::uses('Debugger', 'Utility'); ?>
<?php echo $this->Element('setting', array('mode' => 'general')); ?>
<h1>Settings</h1>
<?php
	echo $this->Form->create('Setting');
	echo $this->Form->input('title', array('type' => 'text', 'label' => 'Name of this site'));
	echo $this->Form->input('top_page', array('type' => 'textarea', 'label' => 'Contents of top page', 'id' => 'top_page'));
	echo $this->Form->input('email_address', array('type' => 'text', 'label' => 'Email address for sending email'));
	echo $this->Form->end('Submit');
?>
<script type="text/javascript">
	tinyMCE.init({
		mode: 'exact',
		elements: 'top_page',
	});
</script>
