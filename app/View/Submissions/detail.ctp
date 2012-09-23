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
$syntax = json_decode($syntax, true);
?>
<h1><?php echo h(sprintf("#%d: %s", $submission['Problem']['id'], $submission['Problem']['name'])); ?></h1>
<h2>Source Code</h2>
<textarea id="source" rows="<?php echo substr_count($submission['Submission']['source'], "\n") + 1; ?>" readonly="readonly"><?php echo h($submission['Submission']['source']); ?></textarea>
<br />
<?php if(count($output) > 0): ?>
<h2>Testcases</h2>
<div class="statement">
	<?php for($i = 0; $i < count($output); $i++): ?>
	<h3><?php echo h(sprintf("#%d: CPU %fsec, Memory %dKB", $i, $cpu[$i], $memory[$i])); ?></h3>
	<div class="row-fluid">
		<div class="span6">
			<pre><?php echo h($input[$i]); ?></pre>
		</div>
		<div class="span6">
			<pre><?php echo h($output[$i]); ?></pre>
		</div>
	</div>
	<?php endfor; ?>
<?php endif; ?>
<script type="text/javascript">
	editAreaLoader.init({
		id: 'source',
		is_editable: false,
		start_highlight: true,
		syntax: "<?php echo h($syntax[$submission['Language']['name']]); ?>"
	});	
</script>
