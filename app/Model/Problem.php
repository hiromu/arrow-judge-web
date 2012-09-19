<?php
App::uses('AppModel', 'Model');

class Problem extends AppModel {
	public $name = 'Problem';
	public $belongsTo = array('Contest', 'User', 'Language');

	public $validate = array(
		'user_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
		),
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
		),
		'cpu' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Must be integer',
			),
		),
		'stack' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Must be integer',
			),
		),
		'memory' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Must be integer',
			),
		),
		'statement' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
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
	);
}
?>
