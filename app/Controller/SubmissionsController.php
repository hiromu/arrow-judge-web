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

class SubmissionsController extends AppController {
	public $name = 'Submissions';
	public $helpers = array('Form');
	public $uses = array('Problem', 'Submission', 'Language', 'Contest', 'Registration', 'Testcase', 'Output');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('*');
		$this->Auth->allow('index');
		$this->Auth->flash['element'] = 'error';
	}

	public function index() {
		$submissions = $this->Submission->find('all', array('limit' => '100', 'order' => 'Submission.created DESC'));
		$this->set('submissions', $submissions);

		$languages = $this->Language->find('all');
		$lang = array();
		foreach($languages as $language) {
			$lang[$language['Language']['id']] = $language['Language']['name'];
		}
		$this->set('lang', $lang);
	}

	public function detail($id = null, $contest_id = null) {
		if(!$id) {
			$this->redirect('index');
		}

		$submission = $this->Submission->findById($id);
		if(!$submission || $submission['Submission']['user_id'] != $this->Auth->user('id')) {
			$this->redirect('index');
		}

		$this->set('contest_id', $contest_id);
		$this->set('submission', $submission);
		$this->set('cpu', json_decode($submission['Submission']['cpu']));
		$this->set('memory', json_decode($submission['Submission']['memory']));
	}

	public function submit($id = null, $contest_id = null) {
		if(!$id) {
			$this->redirect('/problems/index');
		}

		$submission = $this->Problem->findById($id);
		if(!$submission) {
			$this->redirect('/problems/index');
		}

		$submit = $this->request->data;
		if($submission['Problem']['contest_id'] != null && $submission['Problem']['public'] == 0) {
			$register = $this->Registration->find('first', array('condition' => array('AND' => array('Registration.contest_id' => $submission['Problem']['contest_id'], 'Registration.user_id' => $this->Auth->user('id')))));
			if(!$register) {
				$this->Session->setFlash('You are not permitted to submit because you has not registered to this contest');
				$submit = null;
			}
		}

		if($submit) {
			$submit['Submission']['user_id'] = $this->Auth->user('id');
			$submit['Submission']['problem_id'] = $id;
			if($this->Submission->save($submit)) {
				$submission_id = $this->Submission->getLastInsertID();
				if($contest_id) {
					$this->redirect('/submissions/detail/'.$submission_id.'/'.$contest_id);
				} else {
					$this->redirect('detail/'.$submission_id);
				}
			}
		}

		$languages = $this->Language->find('all');
		$lang = array();
		$coloring = array();
		foreach($languages as $language) {
			$lang[$language['Language']['id']] = $language['Language']['name'];
			$coloring[$language['Language']['id']] = $language['Language']['coloring'];
		}
		$this->set('lang', $lang);
		$this->set('coloring', json_encode($coloring, true));
		$this->set('problem', $submission);
		$this->set('contest_id', $contest_id);
	}

	function search($contest_id = null) {
		if(!$this->request->data) {
			$this->redirect('index');
		}

		$conditions = array();
		if(isset($this->request->data['Submission']['problem'])) {
			if($this->request->data['Submission']['problem']) {
				$conditions['Submission.problem_id'] = $this->request->data['Submission']['problem'];
			} else if($contest_id) {
				$contest = $this->Contest->findById($contest_id);
				if($contest) {
					$contest_problem = array();
					foreach($contest['Problem'] as $submission) {
						$contest_problem[] = $submission['id'];
					}
					$conditions['Submission.problem_id'] = $contest_problem;
				}
			}
		}
		if(isset($this->request->data['Submission']['user'])) {
			if($this->request->data['Submission']['user']) {
				$conditions['Submission.user_id'] = $this->request->data['Submission']['user'];
			}
		}
		if($this->request->data['Submission']['language']) {
			$conditions['Submission.language_id'] = $this->request->data['Submission']['language'];
		}
		if($this->request->data['Submission']['status']) {
			$conditions['Submission.status'] = $this->request->data['Submission']['status'];
		}

		$submissions = $this->Submission->find('all', array('conditions' => $conditions, 'limit' => '100', 'order' => 'Submission.created DESC'));
		$this->set('contest_id', $contest_id);
		$this->set('submissions', $submissions);
	}

	function testcase($id = null, $testcase_id = null, $contest_id = null) {
		if(!$id) {
			$this->redirect('index');
		}

		$submission = $this->Submission->findById($id);
		if($submission['Submission']['user_id'] != $this->Auth->user('id')) {
			$this->redirect('index');
		}
		$this->set('submission', $submission);
		$this->set('contest_id', $contest_id);

		$testcase_id -= 1;

		$input = $this->Testcase->find('first', array('conditions' => array('AND' => array('Testcase.problem_id' => $submission['Problem']['id'], 'Testcase.index' => $testcase_id))));
		if(!$input) {
			$this->redirect('index');
		}
		$this->set('input', $input['Testcase']['testcase']);

		$output = $this->Output->find('first', array('conditions' => array('AND' => array('Output.submission_id' => $id, 'Output.index' => $testcase_id))));
		if(!$output) {
			$this->redirect('index');
		}
		$this->set('output', $output['Output']['output']);

		$cpu = json_decode($submission['Submission']['cpu']);
		if(count($cpu) <= $testcase_id || !$cpu[$testcase_id]) {
			$this->redirect('index');
		}
		$this->set('cpu', $cpu[$testcase_id]);

		$memory = json_decode($submission['Submission']['memory']);
		if(count($memory) <= $testcase_id || !$memory[$testcase_id]) {
			$this->redirect('index');
		}
		$this->set('memory', $memory[$testcase_id]);

		$this->set('testcase_id', $testcase_id);
	}
}
