<?php
App::uses('AppModel', 'Model');

class User extends AppModel {
	public $name = 'User';
	public $hasMany = 'Submission';

	public $validate = array(
		'username' => array(
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'This username is already in use',
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
		),
		'password' => array(
			'minLength' => array(
				'rule' => array('minLength', 4),
				'message' => 'Password must be at least 4 characters in length',
			),
			'correspond' => array(
				'rule'    => array('correspond'),
				'message' => 'Password Confirmation mismatched',
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'This email address is invalid',
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'This email address is already in use',
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must not be empty',
			),
		),
	);

	function correspond($check_data) {
		if(isset($this->data[$this->alias]['confirm_password'])) {
			return ($check_data['password'] == $this->data[$this->alias]['confirm_password']);
		}
		return true;
	}

	function beforeSave($options = array()) {
		$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
	}
}
?>
