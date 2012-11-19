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

class JudgesController extends AppController {
	public $name = 'Judges';
	public $helpers = array('Form');
	public $uses = array('Problem', 'Submission', 'Client', 'Testcase', 'Answer', 'Output', 'Contest', 'Registration');

	public function beforeFilter() {
		//$this->Auth->authenticate = array('Basic' => array('userModel' => 'Client', 'fields' => array('username' => 'id', 'password' => 'password')));
		//$this->Auth->deny('*');
		//$this->Auth->autoRedirect = true;

		parent::beforeFilter();
		//parent::setOptions();
		$this->layout = 'ajax';
	}

	public function index($client_id = null) {
		if(!$client_id) {
			$this->redirect('/');
		}

		$client = $this->Client->find('first', array('conditions' => array('client' => $client_id)));
		if(!$client) {
			$this->redirect('/');
		}

		$limit = strftime('%Y-%m-%d %H:%M:%S', time() - $this->options['timeout']);

		$judge = $this->Problem->find('first', array('conditions' => array('OR' => array(array('AND' => array('Problem.status' => '1', 'Problem.modified < ' => $limit)), 'Problem.status' => '0')), 'order' => 'Problem.modified'));
		if($judge) {
			$judge['Problem']['status'] = '1';
			$judge['Problem']['modified'] = null;
			$this->Problem->save($judge, true, array('status', 'modified'));

			$tests = array();
			$testcases = $this->Testcase->find('all', array('conditions' => array('Testcase.problem_id' => $judge['Problem']['id']), 'order' => 'Testcase.index'));
			foreach($testcases as $testcase) {
				$tests[] = $testcase['Testcase']['testcase'];
			}

			$json = array();
			$json['problem'] = '1';
			$json['input'] = $tests;
			foreach(array('id', 'cpu', 'source') as $key) {
				$json[$key] = $judge['Problem'][$key];
			}
			foreach(array('stack', 'memory') as $key) {
				$json[$key] = $judge['Problem'][$key] * 1024;
			}
			foreach(array('extension', 'compile', 'execute') as $key) {
				$json[$key] = $judge['Language'][$key];
			}
			$this->set('judge', json_encode($json));
			return;
		}

		$judge = $this->Submission->find('first', array('conditions' => array('OR' => array(array('AND' => array('Submission.status' => '1', 'Submission.modified < ' => $limit)), 'Submission.status' => '0')), 'order' => 'Submission.modified'));
		if($judge) {
			$judge['Submission']['status'] = '1';
			$judge['Submission']['modified'] = null;
			$this->Submission->save($judge, true, array('status', 'modified'));

			$tests = array();
			$testcases = $this->Testcase->find('all', array('conditions' => array('Testcase.problem_id' => $judge['Problem']['id']), 'order' => 'Testcase.index'));
			foreach($testcases as $testcase) {
				$tests[] = $testcase['Testcase']['testcase'];
			}

			$ans = array();
			$answers = $this->Answer->find('all', array('conditions' => array('Answer.problem_id' => $judge['Problem']['id']), 'order' => 'Answer.index'));
			foreach($answers as $answer) {
				$ans[] = $answer['Answer']['answer'];
			}

			$json = array();
			$json['problem'] = '0';
			$json['input'] = $tests;
			$json['answer'] = $ans;
			$json['cpu'] = $judge['Problem']['cpu'];
			foreach(array('id', 'source') as $key) {
				$json[$key] = $judge['Submission'][$key];
			}
			foreach(array('stack', 'memory') as $key) {
				$json[$key] = $judge['Problem'][$key] * 1024;
			}
			foreach(array('extension', 'compile', 'execute') as $key) {
				$json[$key] = $judge['Language'][$key];
			}
			$this->set('judge', json_encode($json));
			return;
		}

		$this->set('judge', '');
	}

	public function post($client_id = null) {
		if(!$client_id) {
			$this->redirect('/');
		}

		$client = $this->Client->find('first', array('conditions' => array('client' => $client_id)));
		if(!$client) {
			$this->redirect('/');
		}

		$post = $this->request->data;

		$submission = array();
		foreach(array('id', 'status') as $key) {
			$submission[$key] = $post[$key];
		}

		if($post['status'] == 2 || $post['status'] == 3) {
			if($post['problem'] == '1') {
				$submission['error'] = $post['error'];
			} else {
				$outputs = array();
				$submission['error'] = $post['error'];
				$submission['max_cpu'] = 'N/A';
				$submission['max_memory'] = 'N/A';
			}
		} else if($post['status'] == 4 || $post['status'] == 5 || $post['status'] == 6) {
			if($post['problem'] == '1') {
				$answers = json_decode($post['output'], true);
				$submission['submit_cpu'] = $post['cpu'];
				$submission['submit_memory'] = $post['memory'];
			} else {
				$outputs = json_decode($post['output'], true);
				$submission['cpu'] = $post['cpu'];
				$submission['memory'] = $post['memory'];
				$submission['max_cpu'] = max(json_decode($post['cpu'], true));
				$submission['max_memory'] = max(json_decode($post['memory'], true));
			}
		}

		$result = array();
		if($post['problem'] == '1') {
			for($i = 0; $i < count($answers); $i++) {
				$this->Answer->updateAll(array('answer' => '"'.$answers[$i].'"'), array('AND' => array('Answer.problem_id' => $submission['id'], 'Answer.index' => $i)));
			}
			$result['Problem'] = $submission;
			$this->Problem->save($result);
			$this->Submission->updateAll(array('status' => 0), array('Submission.problem_id' => $submission['id']));
		} else {
			$result['Submission'] = $submission;
			$this->Submission->save($result);
			for($i = 0; $i < count($outputs); $i++) {
				$output = $this->Output->find('first', array('conditions' => array('Output.submission_id' => $submission['id'], 'Output.index' => $i)));
				if(!$output) {
					$output = array();
					$output['Output']['id'] = null;
					$output['Output']['submission_id'] = $submission['id'];
					$output['Output']['index'] = $i;
				}
				$output['Output']['output'] = $outputs[$i];
				$this->Output->save($output);
			}

			$problem = $this->Submission->findById($submission['id']);
			if($problem && $problem['Problem']['contest_id'] && !$problem['Problem']['public']) {
				$contest = $this->Contest->findById($problem['Problem']['contest_id']);
				if($contest && $contest['Contest']['start'] <= $problem['Submission']['created'] && $problem['Submission']['created'] <= $contest['Contest']['end']) {
					$register = $this->Registration->find('first', array('conditions' => array('Registration.user_id' => $problem['Submission']['user_id'], 'Registration.contest_id' => $problem['Problem']['contest_id'])));
					if($register) {
						$submissions = $this->Submission->find('all', array('conditions' => array('Submission.problem_id' => $problem['Problem']['id'], 'Submission.user_id' => $problem['Submission']['user_id'], 'Submission.created >=' => $contest['Contest']['start'], 'Submission.created <=' => $contest['Contest']['end']), 'order' => array('Submission.created' => 'ASC')));

						$score = json_decode($register['Registration']['score'], true);
						$score[$problem['Problem']['id']] = '';
						foreach($submissions as $submission) {
							if(3 <= $submission['Submission']['status'] && $submission['Submission']['status'] <= 5) {
								$score[$submission['Problem']['id']] -= 1;
							} else if($submission['Submission']['status'] == 6) {
								$penalty = (strtotime($submission['Submission']['created']) - strtotime($contest['Contest']['start'])) / 60 - $score[$submission['Problem']['id']] * 20;
								$score[$submission['Problem']['id']] = sprintf('%d:%02d (%d)', $penalty / 60, $penalty % 60, $score[$submission['Problem']['id']]);
								break;
							}
						}

						$solved = 0;
						$penalty = 0;
						foreach($score as $key => $value) {
							if($value != '' && $value >= 0) {
								$solved++;
								if(preg_match('/^([0-9]*):([0-9]{2}) \([0-9\-]*\)$/', $value, $match)) {
									$penalty += $match[1] * 60 + $match[2];
								}
							}
						}

						$register['Registration']['solved'] = $solved;
						$register['Registration']['penalty'] = $penalty;
						$register['Registration']['score'] = json_encode($score);
						$this->Registration->save($register);
					}
				}
			}
		}
	}
}
