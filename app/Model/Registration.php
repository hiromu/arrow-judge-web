<?php
App::uses('AppModel', 'Model');

class Registration extends AppModel {
	public $name = 'Registration';
	public $belongsTo = array('User');
	
	public $validate = array(
		'contest_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Must be integer',
			),
		),
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
		'solve' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
		),
	);
}
