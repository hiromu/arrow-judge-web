<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
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
		$this->Auth->authenticate = array('Form' => array('userModel' => 'User', 'fields' => array('username' => 'username', 'password' => 'password')));
		$this->Auth->allow('*');
		$this->Auth->autoRedirect = true;
		$this->Auth->userScope = array('User.active' => true);

		$this->setOptions();
	}

	public function index() {
	}
}
