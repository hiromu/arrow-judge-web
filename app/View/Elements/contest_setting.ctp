<div class="tabbable">
	<ul class="nav nav-tabs">
		<?php if($mode == 'setting'): ?>
		<li class="active"><?php echo $this->Html->link('Contest Settings', '/contests/setting/'.$contest_id); ?></li>
		<?php else: ?>
		<li><?php echo $this->Html->link('Contest Settings', '/contests/setting/'.$contest_id); ?></li>
		<?php endif; ?>
		<?php if($mode == 'notification'): ?>
		<li class="active"><?php echo $this->Html->link('Notifications', '/notifications/index/'.$contest_id); ?></li>
		<?php else: ?>
		<li><?php echo $this->Html->link('Notifications', '/notifications/index/'.$contest_id); ?></li>
		<?php endif; ?>
	</ul>
</div>
