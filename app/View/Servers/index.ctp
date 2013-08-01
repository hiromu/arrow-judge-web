<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Debugger', 'Utility');
echo $this->Element('setting', array('mode' => 'server'));
?>
<h1>Judge Server Settings</h1>
<h2>Disabled Server</h2>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Hostname</th>
			<th>IP Addresss</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($deny as $server): ?>
		<tr>
			<td><?php echo h($server['Server']['hostname']); ?></td>
			<td><?php echo h($server['Server']['address']); ?></td>
			<td><?php echo $this->Html->link('Enable =>', 'enable/'.$server['Server']['id']); ?></td>
			<td><?php echo $this->Html->link('Delete =>', 'delete/'.$server['Server']['id']); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<h2>Enabled Server</h2>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Hostname</th>
			<th>IP Addresss</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($allow as $server): ?>
		<tr>
			<td><?php echo h($server['Server']['hostname']); ?></td>
			<td><?php echo h($server['Server']['address']); ?></td>
			<td><?php echo $this->Html->link('Disable =>', 'disable/'.$server['Server']['id']); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
