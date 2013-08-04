<?php App::uses('Debugger', 'Utility'); ?>
<?php echo $this->Element('contest', array('mode' => 'standings', 'contest_id' => $contest['Contest']['id'])); ?>
<h1>Standings of <?php echo h($contest['Contest']['name']); ?></h1>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Rank</th>
			<th>Username</th>
			<th>Solved</th>
			<th>Penalty</th>
			<?php for($i = 0; $i < count($contest['Problem']); $i++): ?>
			<th><?php echo $this->Html->link(sprintf('#%d', $contest['Problem'][$i]['id']), '/problems/view/'.$contest['Problem'][$i]['id'].'/'.$contest['Contest']['id']); ?></th>
			<?php endfor; ?>
		</tr>
	</thead>
	<tbody>
		<?php for($i = 0; $i < count($registration); $i++): ?>
		<?php $result = $registration[$i]; ?>
		<?php if($i == 0 || $result['Registration']['solved'] != $registration[$i - 1]['Registration']['solved'] || $result['Registration']['penalty'] != $registration[$i - 1]['Registration']['penalty']): ?>
		<?php $rank = $i + 1; ?>
		<?php endif; ?>
		<tr>
			<td><?php echo h($rank); ?></td>
			<td><?php echo $this->Html->link($result['User']['username'], '/users/index/'.$result['User']['id']); ?></td>
			<td><?php echo h($result['Registration']['solved']); ?></td>
			<td><?php echo h(sprintf('%d:%02d', $result['Registration']['penalty'] / 60, $result['Registration']['penalty'] % 60)); ?></td>
			<?php $solve = json_decode($result['Registration']['score'], true); ?>
			<?php for($j = 0; $j < count($contest['Problem']); $j++): ?>
			<?php if($solve[$contest['Problem'][$j]['id']] == ''): ?>
			<td>-</td>
			<?php elseif($solve[$contest['Problem'][$j]['id']] < 0): ?>
			<td style='color: red;'><?php echo h($solve[$contest['Problem'][$j]['id']]); ?></td>
			<?php else: ?>
			<td><?php echo h($solve[$contest['Problem'][$j]['id']]); ?></td>
			<?php endif; ?>
			<?php endfor; ?>
		</tr>
		<?php endfor; ?>
	</tbody>
</table>
