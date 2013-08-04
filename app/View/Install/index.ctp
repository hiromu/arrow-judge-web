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
?>
<h1>Install</h1>
<h2>Directory Permission Status</h2>
<table class="table table-striped">
	<tbody>
		<?php foreach($writable as $directory => $status): ?>
		<tr>
			<td><?php echo h($directory); ?></td>
			<?php if($status): ?>
			<td>OK</td>
			<?php else: ?>
			<td class="error">Not writable</td>
			<?php endif; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php if($ok): ?>
<a class="btn btn-large btn-primary" href="secure">Install</a>
<?php else: ?>
<a class="btn btn-large btn-primary" href="/">Recheck</a>
<?php endif; ?>
