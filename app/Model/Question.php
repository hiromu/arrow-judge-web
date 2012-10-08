<?php
App::uses('AppModel', 'Model');

class Question extends AppModel {
	public $name = 'Question';
	public $belongsTo = array('Problem', 'User');

	public $validate = array(
		'user_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Must be integer',
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
		'question' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
		),
		'public' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Must be integer',
			),
		),
	);
}
?>
