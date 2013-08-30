<?php
App::uses('AppModel', 'Model');

class Notification extends AppModel {
	public $name = 'Notification';

	public $validate = array(
		'data' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
		),
	);
}
