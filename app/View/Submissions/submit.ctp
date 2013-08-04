<?php
App::uses('Debugger', 'Utility');
if($contest_id) {
	echo $this->Element('contest', array('mode' => 'submission', 'contest_id' => $contest_id));
}
?>
<h1><?php echo h(sprintf('#%d: %s', $problem['Problem']['id'], $problem['Problem']['name'])); ?></h1>
<?php
	echo $this->Form->create('Submission');
	echo $this->Form->input('language_id', array('type' => 'select', 'label' => 'Language', 'options' => $lang, 'empty' => false, 'selected' => $latest));
	echo $this->Form->input('source', array('type' => 'textarea', 'label' => 'Source', 'id' => 'source', 'rows' => '20'));
	echo $this->Form->end('Submit');
?>
<script type="text/javascript">
	var edit_area = false;
	var coloring = <?php echo($coloring); ?>;
	function changeLang() {
		var lang_id = $('#SubmissionLanguageId').val();
		if(coloring[lang_id] == '') {
			if(edit_area) {
				editAreaLoader.delete_instance('source');
				edit_area = false;
			}
		} else {
			if(!edit_area) {
				editAreaLoader.init({
					id: 'source',
					toolbar: 'search, go_to_line, |, undo, redo, |, syntax_selection, highlight, reset_highlight, |, help',
					start_highlight: true,
					syntax: coloring[lang_id],
				});
				edit_area = true;
			}
			editAreaLoader.execCommand('source', 'change_syntax', coloring[lang_id]);
		}
	}
	$('#SubmissionLanguageId').bind('change', changeLang);
	changeLang();
</script>
