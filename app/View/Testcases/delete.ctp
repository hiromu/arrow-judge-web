<?php App::uses('Debugger', 'Utility'); ?>
<h1>Problem Setting <?php echo h(sprintf('#%d', $problem_id)); ?></h1>
<h2>Are you sure to delete testcase <?php echo h(sprintf('#%d', $index + 1)); ?>?</h2>
<pre><?php echo h($testcase['Testcase']['testcase']); ?></pre>
<?php
	echo $this->Form->create('Testcase');
	echo $this->Form->input('id', array('type' => 'hidden', 'value' => $testcase['Testcase']['id']));
?>
<div class="submit submit-button">
<?php
	echo $this->Form->submit('Delete', array('div' => false));
	echo $this->Html->link('Cancel', '/problems/setting/'.$problem_id.'/testcase', array('class' => 'btn btn-large'));
?>
</div>
