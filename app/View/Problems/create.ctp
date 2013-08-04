<?php 
App::uses('Debugger', 'Utility');
if($contest_id) {
	echo $this->Element('contest', array('mode' => 'problem', 'contest_id' => $contest_id));
}
?>
<div class="append progress progress-striped active">
	<div class="bar" style="width: 25%;">
		<p>25%</p>
	</div>
</div>
<h1>Create Problem</h1>
<?php echo $this->element('problem_statement'); ?>
