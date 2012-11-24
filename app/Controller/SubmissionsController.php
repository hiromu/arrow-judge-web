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
	public $helpers = array('Form', 'Paginator');
	public $components = array('Session');
	public $uses = array('Problem', 'Submission', 'Language', 'Contest', 'Registration', 'Testcase', 'Output');
	public $paginate = array('limit' => 50, 'order' => array('Submission.created' => 'desc'), 'paramType' => 'querystring');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('*');
		$this->Auth->allow('index', 'search');
		$this->Auth->flash['element'] = 'error';
	}

	public function index() {
		$submissions = $this->paginate('Submission', array('Submission.secret' => 0));
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
		if(!$submission) {
			$this->redirect('index');
		}
		if(!$this->Auth->user('admin')) {
			if($submission['Submission']['user_id'] != $this->Auth->user('id')) {
				$this->redirect('index');
			}
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
			$contest = $this->Contest->findById($id);
			if(!$contest || (!$this->Auth->user('admin') && $contest['Contest']['user_id'] != $this->Auth->user('id'))) {
				$register = $this->Registration->find('first', array('condition' => array('Registration.contest_id' => $submission['Problem']['contest_id'], 'Registration.user_id' => $this->Auth->user('id'))));
				if(!$register) {
					$this->Session->setFlash('You are not permitted to submit because you has not registered to this contest', 'error');
					$submit = null;
				}

				$start_time = strtotime($submission['Contest']['start']);
				if(time() < $start_time) {
					$this->Session->setFlash('You are not permitted to submit because this contest has not started yet', 'error');
					$submit = null;
				}

				$end_time = strtotime($submission['Contest']['end']);
				if($end_time < time()) {
					$this->Session->setFlash('You are not permitted to submit because this contest has already finished', 'error');
					$submit = null;
				}
			} else if($contest && $submit) {
				$submit['Submission']['secret'] = 1;
			}
		}

		if($submit) {
			$submit['Submission']['user_id'] = $this->Auth->user('id');
			$submit['Submission']['problem_id'] = $id;
			$submit['Submission']['length'] = mb_strlen($submit['Submission']['source']);
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
			$lang[$language['Language']['id']] = $language['Language']['detail'];
			$coloring[$language['Language']['id']] = $language['Language']['coloring'];
		}
		$this->set('lang', $lang);
		$this->set('coloring', json_encode($coloring, true));
		$this->set('problem', $submission);
		$this->set('contest_id', $contest_id);
	}

	function search($contest_id = null) {
		if(!$this->request->query) {
			$this->redirect('index');
		}
		$this->request->data['Submission'] = $this->request->query;

		$conditions = array();
		$conditions['Submission.secret'] = 0;

		if($contest_id) {
			$contest = $this->Contest->findById($contest_id);
			if($contest) {
				$contest_problem = array();
				$problem_suggest = array();
				foreach($contest['Problem'] as $problem) {
					$contest_problem[] = $problem['id'];
					$problem_suggest[$problem['id']] = sprintf('#%d: %s', $problem['id'], $problem['name']);
				}
				$this->set('contest', $contest);
				$this->set('problem_suggest', $problem_suggest);

				if(!isset($this->request->data['Submission']['problem']) || !$this->request->data['Submission']['problem']) {
					$conditions['Submission.problem_id'] = $contest_problem;
				}
			}
		}

		if(isset($this->request->data['Submission']['problem']) && $this->request->data['Submission']['problem']) {
			$problem = $this->Problem->findById($this->request->data['Submission']['problem']);
			if($problem) {
				$this->set('problem', $problem);
				$conditions['Submission.problem_id'] = $this->request->data['Submission']['problem'];
			}
		}

		if(isset($this->request->data['Submission']['user'])) {
			if($this->request->data['Submission']['user']) {
				$conditions['Submission.user_id'] = $this->request->data['Submission']['user'];
			}
		}
		if(isset($this->request->data['Submission']['language']) && $this->request->data['Submission']['language'] != '') {
			$conditions['Submission.language_id'] = $this->request->data['Submission']['language'];
		}
		if(isset($this->request->data['Submission']['status']) && $this->request->data['Submission']['status'] != '') {
			$conditions['Submission.status'] = $this->request->data['Submission']['status'];
		}

		$submissions = $this->paginate('Submission', $conditions);
		$this->set('contest_id', $contest_id);
		$this->set('submissions', $submissions);

		$languages = $this->Language->find('all');
		$lang = array();
		foreach($languages as $language) {
			$lang[$language['Language']['id']] = $language['Language']['name'];
		}
		$this->set('lang', $lang);
	}

	function testcase($id = null, $testcase_id = null, $contest_id = null) {
		if(!$id) {
			$this->redirect('index');
		}

		$submission = $this->Submission->findById($id);
		if(!$submission) {
			$this->redirect('index');
		}
		if(!$this->Auth->user('admin')) {
			if($submission['Submission']['user_id'] != $this->Auth->user('id')) {
				$this->redirect('index');
			}
		}
		if($submission['Problem']['public'] == 0 && $submission['Problem']['contest_id'] != null) {
			$contest = $this->Contest->findById($submission['Problem']['contest_id']);
			if($contest && strtotime($contest['Contest']['end']) > time()) {
				$this->Session->setFlash('You are not permitted to view testcase during contest', 'error');
				$this->redirect('detail/'.$id.'/'.$contest_id);
			}
		}
		$this->set('submission', $submission);
		$this->set('contest_id', $contest_id);

		$testcase_id -= 1;

		$input = $this->Testcase->find('first', array('conditions' => array('Testcase.problem_id' => $submission['Problem']['id'], 'Testcase.index' => $testcase_id)));
		if(!$input) {
			$this->redirect('index');
		}
		$input = $input['Testcase']['testcase'];
		if(strlen($input) > $this->options['testcase_limit'] * 1024) {
			$input = substr($input, 0, $this->options['testcase_limit'] * 1024).' ...';
		}
		$this->set('input', $input);

		$output = $this->Output->find('first', array('conditions' => array('Output.submission_id' => $id, 'Output.index' => $testcase_id)));
		if(!$output) {
			$this->redirect('index');
		}
		$output = $output['Output']['output'];
		if(strlen($output) > $this->options['testcase_limit'] * 1024) {
			$output = substr($output, 0, $this->options['testcase_limit'] * 1024).' ...';
		}
		$this->set('output', $output);

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
