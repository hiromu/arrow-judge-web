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

class ProblemsController extends AppController {
	public $name = 'Problems';
	public $helpers = array('Form');
	public $uses = array('Contest', 'Problem', 'Language');
	public $components = array('Session');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('*');
		$this->Auth->allow('index', 'view');
		$this->Auth->flash['element'] = 'error';
	}

	public function index() {
		$publics = $this->Problem->find('all', array('conditions' => array('AND' => array('Problem.public' => '1', 'Problem.status' => '6')), 'order' => 'Problem.modified DESC'));
		$privates = $this->Problem->find('all', array('conditions' => array('AND' => array('Problem.user_id' => $this->Auth->user('id'), 'AND' => array('Problem.contest_id' => null, 'OR' => array('Problem.status !=' => '6', 'Problem.public' => '0')))), 'order' => 'Problem.modified DESC'));
		$this->set('publics', $publics);
		$this->set('privates', $privates);
	}

	public function create($id = null) {
		if($this->request->data) {
			$problem = $this->request->data;
			$problem['Problem']['user_id'] = $this->Auth->user('id');
			$problem['Problem']['cpu'] = 0;
			$problem['Problem']['stack'] = 0;
			$problem['Problem']['memory'] = 0;
			$problem['Problem']['sample_inputs'] = json_encode(array_fill(0, 50, ''));
			$problem['Problem']['sample_outputs'] = json_encode(array_fill(0, 50, ''));
			$problem['Problem']['testcases'] = json_encode(array_fill(0, 100, ''));
			$problem['Problem']['status'] = -1;
			if($id) {
				$contest = $this->Contest->findById($id);
				if($contest) {
					if($contest['Contest']['user_id'] == $this->Auth->user('id') && $contest['Contest']['public'] == 0) {
						$problem['Problem']['contest_id'] = $id;
						$problem['Problem']['public'] = 0;
						if($this->Problem->save($problem)) {
							$this->redirect('setting/'.$this->Problem->getLastInsertID().'/source');
						}
					} else {
						$this->Session->setFlash(sprintf('Unable to add problem to %s', $contest['Contest']['name']), 'error');
					}
				}
			} else {
				if($this->Problem->save($problem)) {
					$this->redirect('setting/'.$this->Problem->getLastInsertID().'/source');
				}
			}
		}

		$problem = array();
		$problem['Problem']['contest_id'] = $id;
		$this->set('problem', $problem);
	}

	public function setting($id = null, $phase = null) {
		if(!$id) {
			$this->redirect('/');
		}

		$problem = $this->Problem->findById($id);
		if($problem['Problem']['user_id'] != $this->Auth->user('id')) {
			$this->redirect('/');
		}

		if($this->request->data) {
			$problem = $this->request->data;
			$problem['Problem']['id'] = $id;
			if($phase == 'source') {
				if($this->Problem->save($problem)) {
					$this->redirect('setting/'.$id.'/sample');
				}
			} else if($phase == 'sample') {
				$sample_inputs = array();
				$sample_outputs = array();
				for($i = 1; isset($problem['Problem']['sample_input'.$i]) && isset($problem['Problem']['sample_output'.$i]); $i++) {
					$sample_inputs[] = $problem['Problem']['sample_input'.$i];
					$sample_outputs[] = $problem['Problem']['sample_output'.$i];
				}
				$problem['Problem']['sample_inputs'] = json_encode($sample_inputs);
				$problem['Problem']['sample_outputs'] = json_encode($sample_outputs);
				if($this->Problem->save($problem)) {
					$this->redirect('setting/'.$id.'/testcase');
				}
			 } else if($phase == 'testcase') {
				$testcases = array();
				for($i = 1; isset($problem['Problem']['testcase'.$i]); $i++) {
					$testcases[] = $problem['Problem']['testcase'.$i];
				}
				$problem['Problem']['testcases'] = json_encode($testcases);
				$problem['Problem']['status'] = 0;
				if($this->Problem->save($problem)) {
					$this->redirect('judge/'.$id);
				}
			} else {
				$problem['Problem']['status'] = -1;
				if($this->Problem->save($problem)) {
					$this->redirect('setting/'.$id.'/source');
				}
			}
		} else {
			if($phase == 'source') {
				$lang = array();
				foreach($this->Language->find('all') as $language) {
					$lang[$language['Language']['id']] = $language['Language']['name'];
				}
				$this->set('lang', $lang);
				$this->set('element', 'problem_source');
				$this->set('percentage', '50%');
			} else if($phase == 'sample') {
				$problem['Problem']['sample_inputs'] = json_decode($problem['Problem']['sample_inputs'], true);
				$problem['Problem']['sample_outputs'] = json_decode($problem['Problem']['sample_outputs'], true);
				for($i = 1; $i <= min(count($problem['Problem']['sample_inputs']), count($problem['Problem']['sample_outputs'])); $i++) {
					$problem['Problem']['sample_input'.$i] = $problem['Problem']['sample_inputs'][$i - 1];
					$problem['Problem']['sample_output'.$i] = $problem['Problem']['sample_outputs'][$i - 1];
				}
				$this->set('element', 'problem_sample');
				$this->set('percentage', '75%');
			} else if($phase == 'testcase') {
				$problem['Problem']['testcases'] = json_decode($problem['Problem']['testcases'], true);
				for($i = 1; $i <= count($problem['Problem']['testcases']); $i++) {
					$problem['Problem']['testcase'.$i] = $problem['Problem']['testcases'][$i - 1];
				}
				$this->set('element', 'problem_testcase');
				$this->set('percentage', '100%');
			} else {
				$this->set('element', 'problem_statement');
				$this->set('percentage', '25%');
			}
			$this->request->data = $problem;
			$this->set('problem', $problem);
		}
	}

	public function judge($id = null) {
		if(!$id) {
			$this->redirect('/');
		}

		$problem = $this->Problem->findById($id);
		if($problem['Problem']['user_id'] != $this->Auth->user('id')) {
			$this->redirect('/');
		}
		$this->set('problem', $problem);

		$this->set('testcases', json_decode($problem['Problem']['testcases'], true));
		$this->set('answers', json_decode($problem['Problem']['answers'], true));
		$this->set('cpu', json_decode($problem['Problem']['submit_cpu'], true));
		$this->set('memory', json_decode($problem['Problem']['submit_memory'], true));
	}

	public function view($id = null) {
		if(!$id) {
			$this->redirect('/');
		}

		$problem = $this->Problem->findById($id);
		if(!$problem) {
			$this->redirect('index');
		}
		if($problem['Problem']['user_id'] != $this->Auth->user('id')) {
			if(($problem['Problem']['public'] == 0 && $problem['Problem']['contest_id'] == null) || $problem['Problem']['status'] != 6) {
				$this->redirect('index');
			}
		}		

		$sample_inputs = json_decode($problem['Problem']['sample_inputs'], true);
		$sample_outputs = json_decode($problem['Problem']['sample_outputs'], true);
		$this->set('problem', $problem);
		$this->set('sample_inputs', $sample_inputs);
		$this->set('sample_outputs', $sample_outputs);
	}
}
