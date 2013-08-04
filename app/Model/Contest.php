<?php
App::uses('AppModel', 'Model');

class Contest extends AppModel {
	public $name = 'Contest';
	public $belongsTo = array('User');
	public $hasMany = array('Problem');

	public $validate = array(
		'admin_id' => array(
			'decimal' => array(
				'rule' => array('decimal'),
				'message' => 'Invalid format',
			),
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
		'start' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				'message' => 'Invalid format',
			),
			'isFuture' => array(
				'rule' => array('isFuture', 'start'),
				'message' => 'Invalid Start time',
			),
		),
		'end' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				'message' => 'Invalid format',
			),
			'isFuture' => array(
				'rule' => array('isFuture', 'end'),
				'message' => 'Invalid End time',
			),
			'isLater' => array(
				'rule' => array('isLater'),
				'message' => 'End time must be later than Start time',
			),
		),
	);

	function isFuture($check_data, $field_name) {
		$data = new DateTime($check_data[$field_name]);
		if($data < new DateTime()) {
			return false;
		}
		return true;
	}

	function isLater($check_data) {
		if($this->data[$this->alias]['start'] > $check_data['end']) {
			return false;
		}
		return true;
	}
}
