<?php
App::uses('AppModel', 'Model');

class Submission extends AppModel {
	public $name = 'Submission';
	public $belongsTo = array('Problem', 'User', 'Language');

	public $validate = array(
		'user_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
		),
		'problem_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Must be integer',
			),
		),
		'language_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Must be integer',
			),
		),
		'source' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
		),
	);
}
?>
