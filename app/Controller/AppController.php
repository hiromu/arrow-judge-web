<?php
App::uses('Controller', 'Controller');

class AppController extends Controller {
	public $name = 'App';
	public $helpers = array('Html', 'Session');
	public $components = array('Auth');
	public $uses = array('Setting');
	public $options = array();

	public function setOptions() {
		$this->set('userid', $this->Auth->user('id'));
		$this->set('username', $this->Auth->user('username'));
		$this->set('admin', $this->Auth->user('admin'));

		foreach($this->Setting->find('all') as $option) {
			$key = $option['Setting']['key'];
			$value = $option['Setting']['value'];
			$this->options[$key] = $value;
			$this->set($key, $value);
		}
	}

	public function beforeFilter() {
		$this->Auth->authenticate = array('Form' => array('userModel' => 'User'));
		$this->Auth->allow('*');
		$this->Auth->autoRedirect = true;
		$this->Auth->userScope = array('User.active' => true);
		$this->Auth->flash['element'] = 'error';

		$this->setOptions();
	}

	public function index() {
	}
}
