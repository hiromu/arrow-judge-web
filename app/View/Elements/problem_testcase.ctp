<script type="text/javascript">
	function initField() {
		target = $('.testcases').children('div');
		for(i = 1; i < target.length; i++) {
			sample = $(target[i - 1]);
			if(sample.find('textarea').val() != '') {
				sample.css('display', '');
			}
		}
		showField($('.testcases').children('div:visible').find('label'));
	}
	function addTestcaseField() {
		target = $('.testcases').children('div');

		for(i = 1; i < target.length; i++) {
			if($(target[i - 1]).css('display') == 'none') {
				$(target[i - 1]).css('display', '');
				break;
			}
		}
	}
	function showField(element) {
		target = $(element).nextAll('div');
		icon = $(element).children('i');
		display = target.css('display');

		if(display == 'none') {
			target.css('display', '');
			icon.removeClass('icon-chevron-up');
			icon.addClass('icon-chevron-down');
		} else {
			target.css('display', 'none');
			icon.removeClass('icon-chevron-down');
			icon.addClass('icon-chevron-up');
		}
	}
</script>
<?php echo $this->Form->create('Problem'); ?>
<div class="testcases">
	<label>Testcases</label>
	<?php for($i = 0; $i < $testcase_limit; $i++): ?>
		<div style="display: none">
			<?php
				echo sprintf('<label onclick="showField(this)"><i class="icon-chevron-down"></i>#%d</label>', $i);
				echo $this->Form->input('testcase'.$i, array('type' => 'textarea', 'label' => 'Testcase '.$i, 'id' => 'testcase'.$i));
			?>
		</div>
	<?php endfor; ?>
	<div>
		<p onclick="addTestcaseField()"><i class="icon-plus-sign"></i>Add Testcase</p>
	</div>
</div>
<div class="submit submit-button">
<?php
	echo $this->Form->submit('Submit', array('div' => false));
	echo $this->Html->link('Back', '/problems/setting/'.$problem['Problem']['id'].'/sample/'.$contest_id, array('class' => 'btn btn-large'));
?>
</div>
<script type="text/javascript">
	initField();
</script>
