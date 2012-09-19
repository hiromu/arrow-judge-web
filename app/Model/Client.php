<?php
App::uses('AppModel', 'Model');

class Client extends AppModel {
	public $name = 'Client';

	public $validate = array(
		'password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
		),
	);
}
?>
