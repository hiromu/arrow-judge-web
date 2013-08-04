<?php
App::uses('Debugger', 'Utility');

$syntax = json_decode($syntax, true);
$coloring = array()
foreach($syntax as $language => $color) {
	$coloring[$color] = $color;
}

echo $this->Element('setting', array('mode' => 'language'));
?>
<h1>Programming Lanuage Settings</h1>
<?php
	echo $this->Form->create('Language');
	echo $this->Form->input('name', array('type' => 'text', 'label' => 'Language name'));
	echo $this->Form->input('detail', array('type' => 'text', 'label' => 'Short description of the language', 'id' => 'top_page'));
	echo $this->Form->input('extension', array('type' => 'text', 'label' => 'Extension for the language'));
	echo $this->Form->input('coloring', array('type' => 'select', 'options' => $coloring));
	echo $this->Form->input('compile', array('type' => 'text', 'label' => 'Compile command'));
	echo $this->Form->input('execute', array('type' => 'text', 'label' => 'Execute command'));
?>
<div class="submit submit-button">
<?php
	echo $this->Form->submit('Submit', array('div' => false));
	echo $this->Html->link('Cancel', 'index', array('class' => 'btn btn-large'));
?>
</div>
