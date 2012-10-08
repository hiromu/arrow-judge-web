<?php
	echo $this->Form->input('cpu', array('type' => 'text', 'label' => 'CPU Limit', 'after' => ' sec'));
	echo $this->Form->input('stack', array('type' => 'text', 'label' => 'Stack Limit', 'after' => 'MB'));
	echo $this->Form->input('memory', array('type' => 'text', 'label' => 'Memory Limit', 'after' => ' MB'));
	echo $this->Form->input('language_id', array('type' => 'select', 'label' => 'Language', 'options' => $lang, 'empty' => false));
	echo $this->Form->input('source', array('type' => 'textarea', 'label' => 'Source', 'id' => 'source', 'rows' => '20'));
?>
<script type="text/javascript">
	var coloring = <?php echo($coloring); ?>;
	function changeLang() {
		var lang_id = $('#ProblemLanguageId').val();
		editAreaLoader.execCommand('source', 'change_syntax', coloring[lang_id]);
	}
	editAreaLoader.init({
		id: 'source',
		toolbar: 'search, go_to_line, |, undo, redo, |, syntax_selection, highlight, reset_highlight, |, help',
		start_highlight: true,
		syntax: coloring[$('#ProblemLanguageId').val()],
	});
	$('#ProblemLanguageId').bind('change', changeLang);
</script>
