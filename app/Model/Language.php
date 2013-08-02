<?php
App::uses('AppModel', 'Model');

class Language extends AppModel {
	public $name = 'Language';

	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
		),
<<<<<<< HEAD
=======
		'detail' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
		),
>>>>>>> 49a3a9e2c2db6c5c6fe448a15c2fc59b13f88d31
		'extension' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
		),
<<<<<<< HEAD
=======
		'coloring' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
		),
		'execute' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
		),
>>>>>>> 49a3a9e2c2db6c5c6fe448a15c2fc59b13f88d31
	);
}
?>
