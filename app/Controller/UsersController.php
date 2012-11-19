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

class UsersController extends AppController {
	public $name = 'Users';
	public $helpers = array('Form', 'Paginator');
	public $uses = array('User', 'Submission', 'Language');
	public $components = array('Email', 'Session');
	public $paginate = array('limit' => 50, 'order' => array('Submission.created' => 'desc'));

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->flash['element'] = 'error';
	}

	public function index($id = null) {
		if(!$id) {
			$this->redirect('/');
		}

		$user = $this->User->findById($id);
		if(!$user) {
			$this->redirect('/');
		}

		$submissions = $this->paginate('Submission', array('Submission.user_id' => $id));
		$this->set('user', $user);
		$this->set('submissions', $submissions);

		$languages = $this->Language->find('all');
		$lang = array();
		foreach($languages as $language) {
			$lang[$language['Language']['id']] = $language['Language']['name'];
		}
		$this->set('lang', $lang);
	}

	public function login() {
		if($this->Auth->user()) {
			$this->redirect('/');
		}
		if($this->request->isPost()) {
			if($this->Auth->login()) {
				if($this->Auth->user('active') == '1') {
					$this->redirect($this->Auth->redirect());
				} else {
					$this->Auth->flash('Your account is not yet confirmed');
					$this->logout();
				}
			} else {
				$this->Auth->flash('Invalid username or password, try again');
			}
		}
	}

	public function logout() {
		$this->Session->delete('auth');
		$this->redirect($this->Auth->logout());
	}

	public function register() {
		if($this->Auth->user()) {
			$this->redirect('/');
		}
		if($this->request->isPost() || $this->request->isPut()) {
			$rand = md5(uniqid(rand(), 1));
			$this->request->data['User']['confirm'] = $rand;
			if($this->User->save($this->request->data)) {
				$this->set('username', $this->request->data['User']['username']);
				$this->set('url', Router::url('confirm', true).'/'.$rand);
				$this->Email->transport = 'Smtp';
				$this->Email->to = $this->request->data['User']['email'];
				$this->Email->from = $this->options['email_address'];
				$this->Email->subject = $this->options['title'].': '.'Registeration Confirmation';
				$this->Email->template = 'register';
				$this->Email->send();

				$this->Session->setFlash('Please click on the link in an email send for your email address.', 'success');
			}
		}
	}

	public function confirm($id = null) {
		if(!$id) {
			$this->redirect('/');
		}

		$userdata = $this->User->find('first', array('conditions' => array('User.confirm' => $id)));
		if($userdata) {
			$userdata['User']['active'] = 1;
			$userdata['User']['confirm'] = md5(uniqid(rand(), 1));
			$this->User->save($userdata, true, array('active', 'confirm'));
		} else {
			$this->redirect('/');
		}
	}

	public function setting() {
		if(!$this->Auth->user()) {
			$this->redirect('/');
		}

		$id = $this->Auth->user('id');
		if($this->request->data) {
			$this->request->data['User']['id'] = $id;
			if($this->User->save($this->request->data)) {
				$user = $this->User->findById($id);
				unset($user['User']['password']);
				$this->Session->write('Auth', $user);
				$this->Session->setFlash('User settings are updated', 'success');
			}
		} else {
			$user = $this->User->findById($id);
			unset($user['User']['password']);
			$this->request->data = $user;
		}
	}
}
