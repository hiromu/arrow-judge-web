<?php
App::uses('AppModel', 'Model');

class Server extends AppModel {
	public $name = 'Server';

	public $validate = array(
		'server' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
		),
		'hostname' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
		),
		'address' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
		),
	);
}
?>
