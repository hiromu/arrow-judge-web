<?php
App::uses('AppController', 'Controller');

class ContestsController extends AppController {
	public $name = 'Contests';
	public $helpers = array('Form');
	public $uses = array('Contest', 'User', 'Registration', 'Problem', 'Submission', 'Language');
	public $components = array('Session');
	public $paginate = array('limit' => 50, 'order' => array('Submission.created' => 'desc'), 'paramType' => 'querystring');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('*');
		$this->Auth->allow('index', 'problem', 'standings');
		$this->Auth->flash['element'] = 'error';
	}

	public function index() {
		$contests = $this->Contest->find('all', array('conditions' => array('OR' => array('Contest.public' => 1, 'AND' => array('Contest.public' => 0, 'Contest.user_id' => $this->Auth->user('id')))), 'order' => 'Contest.created DESC'));
		$this->set('contests', $contests);
	}

	public function create() {
		if(!empty($this->request->data)) {
			$admin = $this->User->find('first', array('conditions' => array('User.username' => $this->request->data['Contest']['admin'])));
			if($admin) {
				$this->request->data['Contest']['user_id'] = $admin['User']['id'];
				$this->request->data['Contest']['public'] = 0;

				$this->request->data['Contest']['start'] = $this->Contest->deconstruct('Contest.start', $this->request->data['Contest']['start']);
				$this->request->data['Contest']['end'] = $this->Contest->deconstruct('Contest.end', $this->request->data['Contest']['end']);

				if($this->Contest->save($this->request->data)) {
					$this->Session->setFlash('New contest are created', 'success');
					$this->redirect('index');
				}
			} else {
				$this->Contest->invalidate('admin', 'User not found');
			}
		}
	}

	public function setting($id = null) {
		if(!$id) {
			$this->redirect('index');
		}

		$contest = $this->Contest->findById($id);
		if(!$contest) {
			$this->redirect('index');
		}
		if(!$this->Auth->user('admin') && $contest['Contest']['user_id'] != $this->Auth->user('id')) {
			$this->redirect('index');
		}

		if($this->request->data) {
			$this->request->data['Contest']['id'] = $id;

			if($contest['Contest']['public'] == 1) {
				$this->request->data['Contest']['public'] = 1;
			}

			$this->request->data['Contest']['start'] = $this->Contest->deconstruct('Contest.start', $this->request->data['Contest']['start']);
			$this->request->data['Contest']['end'] = $this->Contest->deconstruct('Contest.end', $this->request->data['Contest']['end']);

			if($this->Contest->save($this->request->data)) {
				$this->Session->setFlash('Contest settings are updated', 'success');
				$this->redirect('index');
			}
		} else {
			$this->request->data = $contest;
		}
		$this->set('contest', $contest);
	}

	public function register($id = null) {
		if(!$id) {
			$this->redirect('index');
		}

		$contest = $this->Contest->findById($id);
		if(!$contest) {
			$this->redirect('index');
		}
		if($contest['Contest']['user_id'] == $this->Auth->user('id')) {
			$this->redirect('index');
		}
		if($contest['Contest']['public'] == 0) {
			$this->redirect('index');
		}

		if(strtotime($contest['Contest']['start']) > time()) {
			$register = $this->Registration->find('first', array('conditions' => array('Registration.contest_id' => $id, 'Registration.user_id' => $this->Auth->user('id'))));
			if($register) {
				$this->Session->setFlash('You have already registered', 'error');
			} else {
				if($this->request->data) {
					$register = array();
					$register['Registration']['contest_id'] = $id;
					$register['Registration']['user_id'] = $this->Auth->user('id');
					$register['Registration']['solved'] = 0;
					$register['Registration']['penalty'] = 0;

					$score = array();
					for($i = 0; $i < count($contest['Problem']); $i++) {
						$score[$contest['Problem'][$i]['id']] = '';
					}
					$register['Registration']['score'] = json_encode($score);
	
					if($this->Registration->save($register)) {
						$this->Session->setFlash('Registration completed', 'success');
						$this->redirect('index');
					}
				}
			}
		} else {
			$this->Session->setFlash('Contest has already started, you can not register', 'error');
		}

		$this->set('contest', $contest);
	}

	public function problem($id = null) {
		if(!$id) {
			$this->redirect('index');
		}

		$contest = $this->Contest->findById($id);
		if(!$contest) {
			$this->redirect('index');
		}
		if(!$this->Auth->user('admin') && $contest['Contest']['user_id'] != $this->Auth->user('id')) {
			if(strtotime($contest['Contest']['start']) > time()) {
				$this->redirect('index');
			}
		}

		$this->set('contest', $contest);
	}

	public function submission($id = null) {
		if(!$id) {
			$this->redirect('index');
		}

		$contest = $this->Contest->findById($id);
		if(!$contest) {
			$this->redirect('index');
		}
		if(!$this->Auth->user('admin') && $contest['Contest']['user_id'] != $this->Auth->user('id')) {
			if(strtotime($contest['Contest']['start']) > time()) {
				$this->redirect('index');
			}
		}
		$this->set('contest', $contest);

		$problems = array();
		$problem_suggest = array();
		foreach($contest['Problem'] as $problem) {
			$problems[] = $problem['id'];
			$problem_suggest[$problem['id']] = sprintf('#%d: %s', $problem['id'], $problem['name']);
		}
		$submissions = $this->paginate('Submission', array('Submission.user_id' => $this->Auth->user('id'), 'Submission.problem_id' => $problems, 'Submission.created <' => $contest['Contest']['end']));
		$this->set('problem_suggest', $problem_suggest);
		$this->set('submissions', $submissions);

<<<<<<< HEAD
		$languages = $this->Language->find('all');
=======
		$languages = $this->Language->find('all', array('conditions' => array('Language.status', 1)));
>>>>>>> 49a3a9e2c2db6c5c6fe448a15c2fc59b13f88d31
		$lang = array();
		foreach($languages as $language) {
			$lang[$language['Language']['id']] = $language['Language']['name'];
		}
		$this->set('lang', $lang);
	}

	public function standings($id = null) {
		if(!$id) {
			$this->redirect('index');
		}

		$contest = $this->Contest->findById($id);
		if(!$contest) {
			$this->redirect('index');
		}
		if(!$this->Auth->user('admin') && $contest['Contest']['user_id'] != $this->Auth->user('id')) {
			if(strtotime($contest['Contest']['start']) > time()) {
				$this->redirect('index');
			}
		}
		$this->set('contest', $contest);

		$registration = $this->Registration->find('all', array('conditions' => array('Registration.contest_id' => $id), 'order' => array('Registration.solved' => 'desc', 'Registration.penalty' => 'asc')));
		$this->set('registration', $registration);
	}
}
