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
	public $helpers = array('Form', 'Paginator');
	public $uses = array('Contest', 'Problem', 'Language', 'Submission', 'Testcase', 'Answer');
	public $components = array('Session');
	public $paginate = array('limit' => 50, 'order' => array('Submission.created' => 'desc'));

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('*');
		$this->Auth->allow('index', 'view', 'submission');
		$this->Auth->flash['element'] = 'error';
	}

	public function index() {
		$publics = $this->Problem->find('all', array('conditions' => array('Problem.public' => '1', 'Problem.status' => '6'), 'order' => 'Problem.created DESC'));
		$privates = $this->Problem->find('all', array('conditions' => array('AND' => array('Problem.user_id' => $this->Auth->user('id'), 'AND' => array('Problem.contest_id' => null, 'OR' => array('Problem.status !=' => '6', 'Problem.public' => '0')))), 'order' => 'Problem.created DESC'));
		$this->set('publics', $publics);
		$this->set('privates', $privates);
	}

	public function create($id = null) {
		if($this->request->data) {
			$problem = $this->request->data;
			$problem['Problem']['user_id'] = $this->Auth->user('id');
			$problem['Problem']['cpu'] = 0;
			$problem['Problem']['memory'] = 0;
			$problem['Problem']['sample_inputs'] = json_encode(array_fill(0, 50, ''));
			$problem['Problem']['sample_outputs'] = json_encode(array_fill(0, 50, ''));
			$problem['Problem']['status'] = -1;
			if($id) {
				$contest = $this->Contest->findById($id);
				if($contest) {
					if($contest['Contest']['user_id'] == $this->Auth->user('id') && $contest['Contest']['public'] == 0) {
						$problem['Problem']['contest_id'] = $id;
						$problem['Problem']['public'] = 0;
					} else {
						$this->Session->setFlash(sprintf('Unable to add problem to %s', $contest['Contest']['name']), 'error');
					}
				}
			}
			if($this->Problem->save($problem)) {
				$problem_id = $this->Problem->getLastInsertID();
				for($i = 0; $i < 100; $i++) {
					$this->Testcase->create();
					$testcase['Testcase']['problem_id'] = $problem_id;
					$testcase['Testcase']['index'] = $i;
					$this->Testcase->save($testcase);
				}
				for($i = 0; $i < 100; $i++) {
					$this->Answer->create();
					$answer['Answer']['problem_id'] = $problem_id;
					$answer['Answer']['index'] = $i;
					$this->Answer->save($answer);
				}
				$this->redirect('setting/'.$problem_id.'/source');
			}
		}

		$problem = array();
		$problem['Problem']['contest_id'] = $id;
		$this->set('problem', $problem);
	}

	public function setting($id = null, $phase = null) {
		if(!$id) {
			$this->redirect('index');
		}

		$problem = $this->Problem->findById($id);
		if($problem['Problem']['user_id'] != $this->Auth->user('id')) {
			$this->redirect('index');
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
				for($i = 1; isset($problem['Problem']['testcase'.$i]); $i++) {
					$this->Testcase->updateAll(array('testcase' => sprintf('"%s"', $problem['Problem']['testcase'.$i])), array('problem_id' => $id, 'index' => $i - 1));
				}
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
				$coloring = array();
				foreach($this->Language->find('all') as $language) {
					$lang[$language['Language']['id']] = $language['Language']['name'];
					$coloring[$language['Language']['id']] = $language['Language']['coloring'];
				}
				$this->set('lang', $lang);
				$this->set('coloring', json_encode($coloring, true));
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
				$testcase = $this->Testcase->find('all', array('conditions' => array('Testcase.problem_id' => $id), 'order' => 'Testcase.index'));
				$problem['Problem']['testcases'] = array();
				for($i = 1; $i <= count($testcase); $i++) {
					$problem['Problem']['testcases'][] = $testcase[$i - 1]['Testcase']['testcase'];
					$problem['Problem']['testcase'.$i] = $testcase[$i - 1]['Testcase']['testcase'];
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
			$this->redirect('index');
		}

		$problem = $this->Problem->findById($id);
		if($problem['Problem']['user_id'] != $this->Auth->user('id') && !$this->Auth->user('admin')) {
			$this->redirect('index');
		}
		$this->set('problem', $problem);

		$this->set('cpu', json_decode($problem['Problem']['submit_cpu'], true));
		$this->set('memory', json_decode($problem['Problem']['submit_memory'], true));
	}

	public function view($id = null, $contest_id = null) {
		if(!$id) {
			$this->redirect('index');
		}

		$problem = $this->Problem->findById($id);
		if(!$problem) {
			$this->redirect('index');
		}
		if($problem['Problem']['user_id'] != $this->Auth->user('id')) {
			if($problem['Problem']['public'] == 0 && $problem['Problem']['contest_id'] != null) {
				$contest = $this->Contest->findById($problem['Problem']['contest_id']);
				if(!$contest || (!$this->Auth->user('admin') && $contest['Contest']['user_id'] != $this->Auth->user('id'))) {
					if(strtotime($contest['Contest']['start']) > time()) {
						$this->redirect('index');
					}
				}
			}
			if($problem['Problem']['status'] != 6) {
				$this->redirect('index');
			}
		}

		$sample_inputs = json_decode($problem['Problem']['sample_inputs'], true);
		$sample_outputs = json_decode($problem['Problem']['sample_outputs'], true);
		$this->set('problem', $problem);
		$this->set('contest_id', $contest_id);
		$this->set('sample_inputs', $sample_inputs);
		$this->set('sample_outputs', $sample_outputs);
	}

	function submission($id = null, $contest_id = null) {
		if(!$id) {
			$this->redirect('index');
		}

		$problem = $this->Problem->findById($id);
		if(!$problem) {
			$this->redirect('index');
		}
		if($problem['Problem']['user_id'] != $this->Auth->user('id')) {
			if($problem['Problem']['public'] == 0 && $problem['Problem']['contest_id'] != null) {
				$contest = $this->Contest->findById($problem['Problem']['contest_id']);
				if($contest && strtotime($contest['Contest']['start']) > time()) {
					$this->redirect('index');
				}
			}
			if($problem['Problem']['status'] != 6) {
				$this->redirect('index');
			}
		}

		$languages = $this->Language->find('all');
		$lang = array();
		foreach($languages as $language) {
			$lang[$language['Language']['id']] = $language['Language']['name'];
		}
		$this->set('lang', $lang);

		$submissions = $this->paginate('Submission', array('Submission.problem_id' => $id));
		$this->set('submissions', $submissions);
		$this->set('contest_id', $contest_id);
		$this->set('problem', $problem);
	}

	function testcase($id = null, $testcase_id = null) {
		if(!$id) {
			$this->redirect('index');
		}

		$problem = $this->Problem->findById($id);
		if($problem['Problem']['user_id'] != $this->Auth->user('id')) {
			$this->redirect('index');
		}
		$this->set('problem', $problem);

		$testcase_id -= 1;

		$input = $this->Testcase->find('first', array('conditions' => array('Testcase.problem_id' => $id, 'Testcase.index' => $testcase_id)));
		if(!$input) {
			$this->redirect('index');
		}
		$this->set('input', $input['Testcase']['testcase']);

		$output = $this->Answer->find('first', array('conditions' => array('Answer.problem_id' => $id, 'Answer.index' => $testcase_id)));
		if(!$output) {
			$this->redirect('index');
		}
		$this->set('output', $output['Answer']['answer']);

		$cpu = json_decode($problem['Problem']['submit_cpu']);
		if(count($cpu) <= $testcase_id || !$cpu[$testcase_id]) {
			$this->redirect('index');
		}
		$this->set('cpu', $cpu[$testcase_id]);

		$memory = json_decode($problem['Problem']['submit_memory']);
		if(count($memory) <= $testcase_id || !$memory[$testcase_id]) {
			$this->redirect('index');
		}
		$this->set('memory', $memory[$testcase_id]);

		$this->set('testcase_id', $testcase_id);
	}
}
