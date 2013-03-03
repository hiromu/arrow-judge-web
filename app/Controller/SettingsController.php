<?php
App::uses('AppController', 'Controller');

class SettingsController extends AppController {
	public $name = 'Settings';
	public $helpers = array('Form');
	public $uses = array('Setting');
	public $components = array('Session');

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
				if($this->Setting->updateAll(array('value' => "'".$value."'"), array('key' => $key))) {
					$this->Session->setFlash('Settings are updated', 'success');
				}
			}
		}
	}
}
