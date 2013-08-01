<div class="tabbable">
	<ul class="nav nav-tabs">
		<?php if($mode == 'general'): ?>
		<li class="active"><?php echo $this->Html->link('General Settings', '/settings'); ?></li>
		<?php else: ?>
		<li><?php echo $this->Html->link('General Settings', '/settings'); ?></li>
		<?php endif; ?>
		<?php if($mode == 'language'): ?>
		<li class="active"><?php echo $this->Html->link('Programming Language', '/languages'); ?></li>
		<?php else: ?>
		<li><?php echo $this->Html->link('Programming Language', '/languages'); ?></li>
		<?php endif; ?>
		<?php if($mode == 'server'): ?>
		<li class="active"><?php echo $this->Html->link('Judge Server', '/servers'); ?></li>
		<?php else: ?>
		<li><?php echo $this->Html->link('Judge Server', '/servers'); ?></li>
		<?php endif; ?>
	</ul>
</div>
