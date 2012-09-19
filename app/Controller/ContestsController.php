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

class ContestsController extends AppController {
	public $name = 'Contests';
	public $helpers = array('Form');
	public $uses = array('Contest', 'User', 'Regsitration');

	public function index() {
		$contests = $this->Contest->find('all');
		$this->set('contests', $contests);
	}

	public function create() {
		if(!empty($this->request->data)) {
			$contest = array();
			$contest['name'] = $this->data['Contest']['name'];

			$admin = $this->User->find('first', array('conditions' => array('User.username' => $this->request->data['Contest']['admin'])));
			if($admin) {
				$contest['user_id'] = $admin['User']['id'];

				$contest['start'] = $this->Contest->deconstruct('Contest.start', $this->data['Contest']['start']);
				$contest['end'] = $this->Contest->deconstruct('Contest.end', $this->data['Contest']['end']);
				$start = new DateTime($contest['start']);
				$end = new DateTime($contest['end']);

				if($this->Contest->save($contest)) {
					$this->redirect('setting/'.$this->Contest->id);
				}
			} else {
					$this->Contest->invalidate('admin', 'User not found');
			}
		}
	}

	public function setting($id = null) {
		if(!$id) {
			$this->redirect('/');
		}
		$contest = $this->Contest->findById($id);
		if(!$contest || $contest['Contest']['user_id'] != $this->Auth->user('id')) {
			$this->redirect('/');
		}

		if(empty($this->request->data)) {
			$this->request->data = $this->Contest->findById($id);
			$admin = $this->User->findById($this->request->data['Contest']['user_id']);
			$this->request->data['Contest']['admin'] = $admin['User']['username'];
		} else {
			$contest['Contest']['name'] = $this->data['Contest']['name'];

			$admin = $this->User->find('first', array('conditions' => array('User.username' => $this->request->data['Contest']['admin'])));
			if($admin) {
				$contest['Contest']['user_id'] = $admin['User']['id'];
				$contest['Contest']['start'] = $this->Contest->deconstruct('Contest.start', $this->data['Contest']['start']);
				$contest['Contest']['end'] = $this->Contest->deconstruct('Contest.end', $this->data['Contest']['end']);

				$this->Contest->save($contest, true, array('name', 'user_id', 'start', 'end', 'description'));
			} else {
					$this->Contest->invalidate('admin', 'User not found');
			}
		}
	}

	public function redirect($id = null) {
		if(!$id) {
			$this->redirect('/');
		}

		$registration = array();
		$this->Registration->save();
	}
}
