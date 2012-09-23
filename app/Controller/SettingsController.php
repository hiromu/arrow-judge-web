<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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

App::uses('AppController', 'Controller');

class SettingsController extends AppController {
	public $name = 'Settings';
	public $helpers = array('Form');
	public $uses = array('Setting');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('*');
		$this->Auth->flash['element'] = 'error';
	}

	public function index() {
		if(!$this->Auth->user('admin')) {
			$this->redirect('/');
		}

		if(!$this->request->data) {
			foreach($this->options as $key => $value) {
				$this->request->data['Setting'][$key] = $value;
			}
		} else {
			foreach($this->request->data['Setting'] as $key => $value) {
				$this->Setting->updateAll(array('value' => "'".$value."'"), array('key' => $key));
			}
		}
	}
}
