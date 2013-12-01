<?php
App::uses('AppController', 'Controller');

class TestcasesController extends AppController {
	public $name = 'Testcases';
	public $helpers = array('Form');
	public $uses = array('Problem', 'Testcase');
	public $components = array('Session');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('*');
		$this->Auth->flash['element'] = 'error';
	}

	public function add($problem_id = null) {
		if(!$problem_id) {
			$this->redirect('/problems');
		}

		$problem = $this->Problem->findById($problem_id);
		if(!$problem || $problem['Problem']['user_id'] != $this->Auth->user('id') || $problem['Problem']['status'] != -1) {
			$this->redirect('/problems');
		}

		if($this->request->data) {
			if(!$this->request->data['Testcase']['file']['error']) {
				$this->request->data['Testcase']['testcase'] = file_get_contents($this->request->data['Testcase']['file']['tmp_name']);
			}
			var_dump($this->request->data);

			$filename = uniqid();
			if(file_put_contents(ROOT.DS.'app'.DS.'Data'.DS.'Testcase'.DS.$problem_id.DS.$filename, $this->request->data['Testcase']['testcase'])) {
				$this->request->data['Testcase']['problem_id'] = $problem_id;
				$this->request->data['Testcase']['length'] = strlen($this->request->data['Testcase']['testcase']);
				$this->request->data['Testcase']['filename'] = $filename;
				if($this->Testcase->save($this->request->data)) {
					$this->redirect('/problems/setting/'.$problem_id.'/testcase');
				}
			} else {
				 $this->Session->setFlash('Failed to save testcase', 'error');
			}
		}

		$this->set('problem_id', $problem_id);
	}

	public function edit($index = null, $id = null) {
		if(!$id) {
			$this->redirect('/problems');
		}

		$testcase = $this->Testcase->findById($id);
		if(!$testcase) {
			$this->redirect('/problems');
		}

		$problem = $this->Problem->findById($testcase['Testcase']['problem_id']);
		if(!$problem || $problem['Problem']['user_id'] != $this->Auth->user('id') || $problem['Problem']['status'] != -1) {
			$this->redirect('/problems');
		}

		if($this->request->data) {
			if(!$this->request->data['Testcase']['file']['error']) {
				$this->request->data['Testcase']['testcase'] = file_get_contents($this->request->data['Testcase']['file']['tmp_name']);
			}

			if(file_put_contents(ROOT.DS.'app'.DS.'Data'.DS.'Testcase'.DS.$problem['Problem']['id'].DS.$testcase['Testcase']['filename'], $this->request->data['Testcase']['testcase'])) {
				$this->request->data['Testcase']['id'] = $id;
				$this->request->data['Testcase']['length'] = strlen($this->request->data['Testcase']['testcase']);
				if($this->Testcase->save($this->request->data)) {
					$this->redirect('/problems/setting/'.$problem['Problem']['id'].'/testcase');
				}
			} else {
				 $this->Session->setFlash('Failed to save testcase', 'error');
			}
		} else {
			$data = @file_get_contents(ROOT.DS.'app'.DS.'Data'.DS.'Testcase'.DS.$problem['Problem']['id'].DS.$testcase['Testcase']['filename']);
			$this->request->data['Testcase']['testcase'] = $data;
		}

		$this->set('index', $index);
		$this->set('problem_id', $problem['Problem']['id']);
		$this->set('testcase', $testcase);
	}

	public function delete($index = null, $id = null) {
		if(!$id) {
			$this->redirect('/problems');
		}

		$testcase = $this->Testcase->findById($id);
		if(!$testcase) {
			$this->redirect('/problems');
		}

		$problem = $this->Problem->findById($testcase['Testcase']['problem_id']);
		if(!$problem || $problem['Problem']['user_id'] != $this->Auth->user('id') || $problem['Problem']['status'] != -1) {
			$this->redirect('/problems');
		}

		if($this->request->data) {
			if($this->request->data['Testcase']['id'] == $id) {
				$this->Testcase->delete($id);
				unlink(ROOT.DS.'app'.DS.'Data'.DS.'Testcase'.DS.$problem['Problem']['id'].DS.$testcase['Testcase']['filename']);
				$this->redirect('/problems/setting/'.$problem['Problem']['id'].'/testcase');
			}
		} else {
			$data = @file_get_contents(ROOT.DS.'app'.DS.'Data'.DS.'Testcase'.DS.$problem['Problem']['id'].DS.$testcase['Testcase']['filename']);
			if(strlen($data) > $this->options['testcase_limit'] * 1024) {
				$data = substr($data, 0, $this->options['testcase_limit'] * 1024).' ...';
			}
			$testcase['Testcase']['testcase'] = $data;
		}

		$this->set('index', $index);
		$this->set('problem_id', $problem['Problem']['id']);
		$this->set('testcase', $testcase);
	}
}
