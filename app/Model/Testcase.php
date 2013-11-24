<?php
App::uses('AppModel', 'Model');

class Testcase extends AppModel {
	public $name = 'Testcase';

	public $validate = array(
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
		'length' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Must be integer',
			),
		),
		'filename' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
		),
	);
}
