<div class="tabbable">
	<ul class="nav nav-tabs">
		<?php if($mode == 'problem'): ?>
		<li class="active"><?php echo $this->Html->link('Problems', '/contests/problem/'.$contest_id); ?></li>
		<?php else: ?>
		<li><?php echo $this->Html->link('Problems', '/contests/problem/'.$contest_id); ?></li>
		<?php endif; ?>
		<?php if($mode == 'submission'): ?>
		<li class="active"><?php echo $this->Html->link('My Submissions', '/contests/submission/'.$contest_id); ?></li>
		<?php else: ?>
		<li><?php echo $this->Html->link('My Submissions', '/contests/submission/'.$contest_id); ?></li>
		<?php endif; ?>
		<?php if($mode == 'standings'): ?>
		<li class="active"><?php echo $this->Html->link('Standings', '/contests/standings/'.$contest_id); ?></li>
		<?php else: ?>
		<li><?php echo $this->Html->link('Standings', '/contests/standings/'.$contest_id); ?></li>
		<?php endif; ?>
	</ul>
</div>
