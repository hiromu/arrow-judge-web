<?php App::uses('Debugger', 'Utility'); ?>
<h1>Problem Setting <?php echo h(sprintf('#%d', $problem_id)); ?></h1>
<?php
	echo $this->Form->create('Testcase');
	echo $this->Form->input('testcase', array('type' => 'textarea', 'label' => sprintf('Testcase #%d', $index + 1)));
?>
<div class="submit submit-button">
<?php
	echo $this->Form->submit('Submit', array('div' => false));
	echo $this->Html->link('Cancel', '/problems/setting/'.$problem_id.'/testcase', array('class' => 'btn btn-large'));
?>
</div>
