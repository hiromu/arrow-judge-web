<?php
App::uses('Debugger', 'Utility');
if($contest_id) {
	echo $this->Element('contest', array('mode' => 'problem', 'contest_id' => $contest_id));
}
?>
<div class="append progress progress-striped active">
	<div class="bar" style="width: <?php echo h($percentage); ?>;">
		<p><?php echo h($percentage); ?></p>
	</div>
</div>
<h1>Problem Setting <?php echo h(sprintf('#%d', $problem['Problem']['id'])); ?></h1>
<?php echo $this->element($element); ?>
