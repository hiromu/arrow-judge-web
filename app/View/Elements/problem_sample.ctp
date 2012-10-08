<script type="text/javascript">
	function initField() {
		target = $('.samples').children('div');
		for(i = 1; i < target.length; i++) {
			sample = $(target[i - 1]);
			if(sample.find('textarea').val() != '') {
				sample.css('display', '');
//				tinyMCE.settings = {
//					width: '100%'
//				};
//				tinyMCE.execCommand('mceAddControl', true, 'sample_input' + i);
//				tinyMCE.execCommand('mceAddControl', true, 'sample_output' + i);
			}
		}
		showField($('.samples').children('div:visible').find('label'));
	}
	function addSampleField() {
		target = $('.samples').children('div');

		for(i = 1; i < target.length; i++) {
			if($(target[i - 1]).css('display') == 'none') {
				$(target[i - 1]).css('display', '');
				break;
			}
		}
//		tinyMCE.execCommand('mceAddControl', true, 'sample_input' + i);
//		tinyMCE.execCommand('mceAddControl', true, 'sample_output' + i);
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
<div class="samples">
	<label>Sample Input/Output</label>
	<?php for($i = 1; $i <= min(count($problem['Problem']['sample_inputs']), count($problem['Problem']['sample_outputs'])); $i++): ?>
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
<script type="text/javascript">
	initField();
</script>
