<?php
App::uses('AppController', 'Controller');

class ProblemsController extends AppController {
	public $name = 'Problems';
	public $helpers = array('Form', 'Paginator');
	public $uses = array('Contest', 'Problem', 'Language', 'Submission', 'Notification');
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
		if($this->Auth->user('admin')) {
			$privates = $this->Problem->find('all', array('conditions' => array('AND' => array('Problem.contest_id' => null, 'OR' => array('Problem.status !=' => '6', 'Problem.public' => '0'))), 'order' => 'Problem.created DESC'));
		} else {
			$privates = $this->Problem->find('all', array('conditions' => array('AND' => array('Problem.user_id' => $this->Auth->user('id'), 'AND' => array('Problem.contest_id' => null, 'OR' => array('Problem.status !=' => '6', 'Problem.public' => '0')))), 'order' => 'Problem.created DESC'));
		}
		$this->set('publics', $publics);
		$this->set('privates', $privates);
	}

	public function create($contest_id = null) {
		if($this->request->data) {
			$problem = $this->request->data;
			$problem['Problem']['user_id'] = $this->Auth->user('id');
			$problem['Problem']['cpu'] = 0;
			$problem['Problem']['memory'] = 0;
			$problem['Problem']['sample_inputs'] = json_encode(array_fill(0, $this->options['sample_limit'], ''));
			$problem['Problem']['sample_outputs'] = json_encode(array_fill(0, $this->options['sample_limit'], ''));
			$problem['Problem']['status'] = -1;
			$problem['Problem']['statement'] = Purifier::clean($problem['Problem']['statement'], 'Default');

			if($contest_id) {
				$contest = $this->Contest->findById($contest_id);
				if($contest) {
					if($contest['Contest']['user_id'] == $this->Auth->user('id') && $contest['Contest']['public'] == 0) {
						$problem['Problem']['contest_id'] = $contest_id;
						$problem['Problem']['public'] = 0;
					} else {
						$this->Session->setFlash(sprintf('Unable to add problem to %s', $contest['Contest']['name']), 'error');
						$problem = null;
					}
				}
			}

			if($problem && $this->Problem->save($problem)) {
				$problem_id = $this->Problem->getLastInsertID();

				$testcase_dir = ROOT.DS.'app'.DS.'Data'.DS.'Testcase'.DS.$problem_id;
				if(file_exists($testcase_dir)) {
					if(!is_dir($testcase_dir)) {
						unlink($testcase_dir);
						mkdir($testcase_dir);
					}
				} else {
					mkdir($testcase_dir);
				}

				$answer_dir = ROOT.DS.'app'.DS.'Data'.DS.'Answer'.DS.$problem_id;
				if(file_exists($answer_dir)) {
					if(!is_dir($answer_dir)) {
						unlink($answer_dir);
						mkdir($answer_dir);
					}
				} else {
					mkdir($answer_dir);
				}

				$this->redirect('setting/'.$problem_id.'/source/'.$contest_id);
			}
		}

		$problem = array();
		$problem['Problem']['contest_id'] = $contest_id;
		$this->set('problem', $problem);
		$this->set('contest_id', $contest_id);
		$this->set('notifications', $this->Notification->find('all', array('conditions' => array('Notification.active' => 1, 'Notification.contest_id' => $contest_id))));
	}

	public function setting($id = null, $phase = null, $contest_id = null) {
		if(!$id) {
			$this->redirect('index');
		}

		$problem = $this->Problem->findById($id);
		if($problem['Problem']['user_id'] != $this->Auth->user('id')) {
			$this->redirect('index');
		}

		$this->set('contest_id', $contest_id);
		if($this->request->data) {
			$problem = $this->request->data;
			$problem['Problem']['id'] = $id;
			if($phase == 'source') {
				if($this->Problem->save($problem)) {
					$this->redirect('setting/'.$id.'/sample/'.$contest_id);
				}
			} else if($phase == 'sample') {
				$sample_inputs = array();
				$sample_outputs = array();
				for($i = 0; $i < $this->options['sample_limit']; $i++) {
					$sample_inputs[] = $problem['Problem']['sample_input'.$i];
					$sample_outputs[] = $problem['Problem']['sample_output'.$i];
				}
				$problem['Problem']['sample_inputs'] = json_encode($sample_inputs);
				$problem['Problem']['sample_outputs'] = json_encode($sample_outputs);
				if($this->Problem->save($problem)) {
					$this->redirect('setting/'.$id.'/testcase/'.$contest_id);
				}
			 } else if($phase == 'testcase') {
				$testcase_dir = ROOT.DS.'app'.DS.'Data'.DS.'Testcase'.DS.$id;
				for($i = 0; $i < $this->options['testcase_limit']; $i++) {
					file_put_contents($testcase_dir.DS.$i, $problem['Problem']['testcase'.$i]);
				}
				$problem['Problem']['status'] = 0;
				if($this->Problem->save($problem)) {
					$this->redirect('judge/'.$id.'/'.$contest_id);
				}
			} else {
				$problem['Problem']['status'] = -1;
				$problem['Problem']['statement'] = Purifier::clean($problem['Problem']['statement'], 'Default');
				if($this->Problem->save($problem)) {
					$this->redirect('setting/'.$id.'/source/'.$phase);
				} else if($phase) {
					$this->set('contest_id', $phase);
				}
			}
		} else {
			if($phase == 'source') {
				$lang = array();
				$coloring = array();
				foreach($this->Language->find('all', array('conditions' => array('Language.status', 1))) as $language) {
					$lang[$language['Language']['id']] = $language['Language']['name'];
					$coloring[$language['Language']['id']] = $language['Language']['coloring'];
				}
				$this->set('lang', $lang);
				$this->set('coloring', json_encode($coloring));
				$this->set('element', 'problem_source');
				$this->set('percentage', '50%');
			} else if($phase == 'sample') {
				$problem['Problem']['sample_inputs'] = json_decode($problem['Problem']['sample_inputs'], true);
				$problem['Problem']['sample_outputs'] = json_decode($problem['Problem']['sample_outputs'], true);
				for($i = 0; $i < $this->options['sample_limit']; $i++) {
					$problem['Problem']['sample_input'.$i] = $problem['Problem']['sample_inputs'][$i];
					$problem['Problem']['sample_output'.$i] = $problem['Problem']['sample_outputs'][$i];
				}
				$this->set('element', 'problem_sample');
				$this->set('percentage', '75%');
			} else if($phase == 'testcase') {
				$testcase_dir = ROOT.DS.'app'.DS.'Data'.DS.'Testcase'.DS.$id;
				for($i = 0; $i < $this->options['testcase_limit']; $i++) {
					$problem['Problem']['testcase'.$i] = @file_get_contents($testcase_dir.DS.$i);
				}
				$this->set('element', 'problem_testcase');
				$this->set('percentage', '100%');
			} else {
				$this->set('element', 'problem_statement');
				$this->set('percentage', '25%');
				if($phase) {
					$this->set('contest_id', $phase);
				}
			}
			$this->request->data = $problem;
			$this->set('problem', $problem);
			$this->set('notifications', $this->Notification->find('all', array('conditions' => array('Notification.active' => 1, 'Notification.contest_id' => $contest_id))));
		}
	}

	public function judge($id = null, $contest_id = null) {
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
		$this->set('contest_id', $contest_id);
		$this->set('notifications', $this->Notification->find('all', array('conditions' => array('Notification.active' => 1, 'Notification.contest_id' => $contest_id))));
	}

	public function view($id = null, $contest_id = null) {
		if(!$id) {
			$this->redirect('index');
		}

		$problem = $this->Problem->findById($id);
		if(!$problem) {
			$this->redirect('index');
		}

		if(!$this->Auth->user('admin') && $problem['Problem']['user_id'] != $this->Auth->user('id')) {
			if($problem['Problem']['public'] == 0) {
				if($problem['Problem']['contest_id']) {
					$contest = $this->Contest->findById($problem['Problem']['contest_id']);
					if(!$contest || $contest['Contest']['user_id'] != $this->Auth->user('id')) {
						if(strtotime($contest['Contest']['start']) > time()) {
							$this->redirect('index');
						}
					}
				} else {
					$this->redirect('index');
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
		$this->set('notifications', $this->Notification->find('all', array('conditions' => array('Notification.active' => 1, 'Notification.contest_id' => $contest_id))));
	}

	public function submission($id = null, $contest_id = null) {
		if(!$id) {
			$this->redirect('index');
		}

		$problem = $this->Problem->findById($id);
		if(!$problem) {
			$this->redirect('index');
		}

		if(!$this->Auth->user('admin') && $problem['Problem']['user_id'] != $this->Auth->user('id')) {
			if($problem['Problem']['public'] == 0) {
				if($problem['Problem']['contest_id']) {
					$contest = $this->Contest->findById($problem['Problem']['contest_id']);
					if(!$contest || $contest['Contest']['user_id'] != $this->Auth->user('id')) {
						if(strtotime($contest['Contest']['start']) > time()) {
							$this->redirect('index');
						}
					}
				} else {
					$this->redirect('index');
				}
			}
			if($problem['Problem']['status'] != 6) {
				$this->redirect('index');
			}
		}

		$languages = $this->Language->find('all', array('conditions' => array('Language.status', 1)));
		$lang = array();
		foreach($languages as $language) {
			$lang[$language['Language']['id']] = $language['Language']['name'];
		}
		$this->set('lang', $lang);

		$submissions = $this->paginate('Submission', array('Submission.problem_id' => $id));
		$this->set('submissions', $submissions);
		$this->set('contest_id', $contest_id);
		$this->set('problem', $problem);
		$this->set('notifications', $this->Notification->find('all', array('conditions' => array('Notification.active' => 1, 'Notification.contest_id' => $contest_id))));
	}

	public function testcase($id = null, $testcase_id = null) {
		if(!$id) {
			$this->redirect('index');
		}

		$problem = $this->Problem->findById($id);
		if($problem['Problem']['user_id'] != $this->Auth->user('id') && !$this->Auth->user('admin')) {
			$this->redirect('index');
		}
		$this->set('problem', $problem);

		$testcase_id -= 1;

		$input = file_get_contents(ROOT.DS.'app'.DS.'Data'.DS.'Testcase'.DS.$id.DS.$testcase_id);
		if(!$input) {
			$this->redirect('index');
		}
		$this->set('input', $input);

		$output = @file_get_contents(ROOT.DS.'app'.DS.'Data'.DS.'Answer'.DS.$id.DS.$testcase_id);
		if(!$output) {
			$output = '';
		}
		$this->set('output', $output);

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

	public function delete($id = null, $contest_id = null) {
		if(!$id) {
			$this->redirect('index');
		}

		$problem = $this->Problem->findById($id);
		if(!$problem) {
			$this->redirect('index');
		}
		if($problem['Problem']['user_id'] != $this->Auth->user('id')) {
			$this->redirect('index');
		}

		if($this->request->data) {
			if($this->request->data['Problem']['id'] == $id) {
				$this->Problem->delete($id);
			}
			if($contest_id) {
				$this->redirect('/contests/problem/'.$contest_id);
			} else {
				$this->redirect('index');
			}
		}

		$this->set('contest_id', $contest_id);
		$this->set('problem', $problem);
		$this->set('notifications', $this->Notification->find('all', array('conditions' => array('Notification.active' => 1, 'Notification.contest_id' => $contest_id))));
	}
}
