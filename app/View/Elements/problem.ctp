<script type="text/javascript">
	function initField() {
		target = $('.samples').children('div');
		for(i = 1; i < target.length; i++) {
			sample = $(target[i - 1]);
			if(sample.find('textarea').val() != '') {
				sample.css('display', '');
				tinyMCE.settings = {
					width: '100%'
				};
				tinyMCE.execCommand('mceAddControl', true, 'sample_input' + i);
				tinyMCE.execCommand('mceAddControl', true, 'sample_output' + i);
			}
		}
		showField($('.samples').children('div:visible').find('label'));

		target = $('.testcases').children('div');
		for(i = 1; i < target.length; i++) {
			sample = $(target[i - 1]);
			if(sample.find('textarea').val() != '') {
				sample.css('display', '');
			}
		}
		showField($('.testcases').children('div:visible').find('label'));
	}
	function addSampleField() {
		target = $('.samples').children('div');

		for(i = 1; i < target.length; i++) {
			if($(target[i - 1]).css('display') == 'none') {
				$(target[i - 1]).css('display', '');
				break;
			}
		}
		tinyMCE.execCommand('mceAddControl', true, 'sample_input' + i);
		tinyMCE.execCommand('mceAddControl', true, 'sample_output' + i);
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
<?php
	echo $this->Session->flash();
	echo $this->Form->create('Problem');
	echo $this->Form->input('name', array('type' => 'text', 'label' => 'Contest Name'));
	echo $this->Form->input('cpu', array('type' => 'text', 'label' => 'CPU Limit', 'after' => ' sec'));
	echo $this->Form->input('stack', array('type' => 'text', 'label' => 'Stack Limit', 'after' => 'MB'));
	echo $this->Form->input('memory', array('type' => 'text', 'label' => 'Memory Limit', 'after' => ' MB'));
	echo $this->Form->input('statement', array('type' => 'textarea', 'label' => 'Statement', 'id' => 'statement'));
?>
<div class="samples">
	<label>Sample Input/Output</label>
	<?php for($i = 1; $i <= 50; $i++): ?>
		<div style="display: none">
			<?php
				echo sprintf('<label onclick="showField(this)"><i class="icon-chevron-down"></i>#%d</label>', $i);
				echo $this->Form->input('sample_input'.$i, array('type' => 'textarea', 'label' => 'Sample Input '.$i, 'id' => 'sample_input'.$i));
				echo $this->Form->input('sample_output'.$i, array('type' => 'textarea', 'label' => 'Sample Output '.$i, 'id' => 'sample_output'.$i));
			?>
		</div>
	<?php endfor; ?>
	<div>
		<p onclick="addSampleField()"><i class="icon-plus-sign"></i>Add Sample Input/Output</p>
	</div>
</div>
<div class="testcases">
	<label>Testcases</label>
	<?php for($i = 1; $i <= 100; $i++): ?>
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
<?php
	echo $this->Form->input('language_id', array('type' => 'select', 'label' => 'Language', 'options' => $lang, 'empty' => false));
	echo $this->Form->input('source', array('type' => 'textarea', 'label' => 'Source', 'id' => 'source', 'rows' => '20'));
	echo $this->Form->input('public', array('type' => 'radio', 'label' => 'Public', 'options' => array('0' => 'private', '1' => 'public')));
?>
<script type="text/javascript">
	tinyMCE.init({
		mode: 'exact',
		elements: 'statement',
	});
	editAreaLoader.init({
		id: 'source',
		toolbar: 'search, go_to_line, |, undo, redo, |, syntax_selection, highlight, reset_highlight, |, help',
		start_highlight: true,
	});
	initField();
</script>
