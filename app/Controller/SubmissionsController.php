<?php
App::uses('AppController', 'Controller');

class SubmissionsController extends AppController {
	public $name = 'Submissions';
	public $helpers = array('Form', 'Paginator');
	public $components = array('Session');
	public $uses = array('Problem', 'Submission', 'Language', 'Contest', 'Registration', 'Notification', 'Testcase');
	public $paginate = array('limit' => 50, 'order' => array('Submission.created' => 'desc'), 'paramType' => 'querystring');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('*');
		$this->Auth->allow('index', 'search', 'detail', 'testcase');
		$this->Auth->flash['element'] = 'error';
	}

	public function index() {
		$submissions = $this->paginate('Submission', array('Submission.secret' => 0));
		$this->set('submissions', $submissions);

		$languages = $this->Language->find('all', array('conditions' => array('Language.status', 1)));
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
		if(!$submission || $submission['Problem']['public'] == 2) {
			$this->redirect('index');
		}
		if($submission['Problem']['public'] == 0) {
			if(!$this->Auth->user('admin')) {
				if($submission['Problem']['contest_id']) {
					$contest = $this->Contest->findById($submission['Problem']['contest_id']);
					if(!$contest || $contest['Contest']['user_id'] != $this->Auth->user('id')) {
						if(strtotime($contest['Contest']['end']) > time()) {
							if($submission['Submission']['user_id'] != $this->Auth->user('id')) {
								$this->Session->setFlash('You are not permitted to view submissions of the others during contest', 'error');
								$this->redirect('index');
							} else if($submission['Submission']['error']) {
								$submission['Submission']['error'] = '- You are not permitted to view error messages during contest -';
							}
						}
					}
				} else if($submission['Submission']['user_id'] != $this->Auth->user('id')) {
					$this->Session->setFlash('You are not permitted to view submissions of the secret problem', 'error');
					$this->redirect('index');
				}
			}
		}

		$this->set('contest_id', $contest_id);
		$this->set('submission', $submission);
		$this->set('cpu', json_decode($submission['Submission']['cpu']));
		$this->set('memory', json_decode($submission['Submission']['memory']));
		$this->set('notifications', $this->Notification->find('all', array('conditions' => array('Notification.active' => 1, 'Notification.contest_id' => $contest_id))));
	}

	public function submit($id = null, $contest_id = null) {
		if(!$id) {
			$this->redirect('/problems/index');
		}

		$problem = $this->Problem->findById($id);
		if(!$problem || $problem['Problem']['public'] == 2) {
			$this->redirect('/problems/index');
		}

		$submit = $this->request->data;
		if($submit && ($problem['Problem']['public'] == 0 || $problem['Problem']['status'] != 6)) {
			if($problem['Problem']['contest_id']) {
				$contest = $this->Contest->findById($problem['Problem']['contest_id']);
				if($contest) {
					if(!$this->Auth->user('admin') && $contest['Contest']['user_id'] != $this->Auth->user('id')) {
						$start_time = strtotime($problem['Contest']['start']);
						if(time() < $start_time) {
							$this->Session->setFlash('You are not permitted to submit because this contest has not started yet', 'error');
							$submit = null;
						}

						$end_time = strtotime($problem['Contest']['end']);
						if($end_time < time()) {
							$this->Session->setFlash('You are not permitted to submit because this contest has already finished', 'error');
							$submit = null;
						}

						$register = $this->Registration->find('first', array('conditions' => array('Registration.contest_id' => $problem['Problem']['contest_id'], 'Registration.user_id' => $this->Auth->user('id'))));
						if(!$register) {
							$register = array();
							$register['Registration']['contest_id'] = $problem['Problem']['contest_id'];
							$register['Registration']['user_id'] = $this->Auth->user('id');
							$register['Registration']['solved'] = 0;
							$register['Registration']['penalty'] = 0;

							$score = array();
							for($i = 0; $i < count($contest['Problem']); $i++) {
								$score[$contest['Problem'][$i]['id']] = '';
							}
							$register['Registration']['score'] = json_encode($score);

							if(!$this->Registration->save($register)) {
								$submit = null;
							}
						}
					} else {
						$submit['Submission']['secret'] = 1;
					}
				}
			} else if($this->Auth->user('admin') || $problem['Problem']['user_id'] == $this->Auth->user('id')) {
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

		$latest = $this->Submission->find('first', array('conditions' => array('Submission.user_id' => $this->Auth->user('id')), 'order' => array('Submission.created' => 'DESC')));
		$this->set('latest', $latest['Submission']['language_id']);

		$languages = $this->Language->find('all', array('conditions' => array('Language.status', 1)));
		$lang = array();
		$coloring = array();
		foreach($languages as $language) {
			$lang[$language['Language']['id']] = $language['Language']['detail'];
			$coloring[$language['Language']['id']] = $language['Language']['coloring'];
		}
		$this->set('lang', $lang);
		$this->set('coloring', json_encode($coloring, true));
		$this->set('problem', $problem);
		$this->set('contest_id', $contest_id);
		$this->set('notifications', $this->Notification->find('all', array('conditions' => array('Notification.active' => 1, 'Notification.contest_id' => $contest_id))));
	}

	public function search($contest_id = null) {
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

		$languages = $this->Language->find('all', array('conditions' => array('Language.status', 1)));
		$lang = array();
		foreach($languages as $language) {
			$lang[$language['Language']['id']] = $language['Language']['name'];
		}
		$this->set('lang', $lang);

		$this->set('notifications', $this->Notification->find('all', array('conditions' => array('Notification.active' => 1, 'Notification.contest_id' => $contest_id))));
	}

	public function testcase($id = null, $testcase_id = null, $contest_id = null) {
		if(!$id) {
			$this->redirect('index');
		}

		$submission = $this->Submission->findById($id);
		if(!$submission || $submission['Problem']['public'] == 2) {
			$this->redirect('index');
		}
		if($submission['Problem']['public'] == 0) {
			if(!$this->Auth->user('admin') && $submission['Problem']['user_id'] != $this->Auth->user('id')) {
				if($submission['Problem']['contest_id']) {
					$contest = $this->Contest->findById($submission['Problem']['contest_id']);
					if(!$contest || $contest['Contest']['user_id'] != $this->Auth->user('id')) {
						if(strtotime($contest['Contest']['end']) > time()) {
							$this->Session->setFlash('You are not permitted to view testcases during contest', 'error');
							$this->redirect('detail/'.$id);
						}
					}
				} else {
					$this->Session->setFlash('You are not permitted to view testcases of the secret problem', 'error');
					$this->redirect('detail/'.$id);
				}
			}
		}
		$this->set('submission', $submission);
		$this->set('contest_id', $contest_id);

		$testcase_id -= 1;

		$testcases = $this->Testcase->find('all', array('conditions' => array('Testcase.problem_id' => $submission['Problem']['id']), 'offset' => $testcase_id, 'limit' => 1));
		$input = file_get_contents(ROOT.DS.'app'.DS.'Data'.DS.'Testcase'.DS.$submission['Problem']['id'].DS.$testcases[0]['Testcase']['filename']);
		if(!$input) {
			$this->redirect('detail', $id);
		}
		if(strlen($input) > $this->options['testcase_limit'] * 1024) {
			$input = substr($input, 0, $this->options['testcase_limit'] * 1024).' ...';
		}
		$this->set('input', $input);

		$output = @file_get_contents(ROOT.DS.'app'.DS.'Data'.DS.'Output'.DS.$id.DS.$testcase_id);
		if(!$output) {
			$output = '';
		}
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
		$this->set('notifications', $this->Notification->find('all', array('conditions' => array('Notification.active' => 1, 'Notification.contest_id' => $contest_id))));
	}
}
