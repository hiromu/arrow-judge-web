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
	public $uses = array('Problem', 'Language');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('*');
		$this->Auth->allow('index', 'view');
		$this->Auth->flash['element'] = 'error';
	}

	public function index() {
		$problems = $this->Problem->find('all', array('conditions' => array('OR' => array('Problem.user_id' => $this->Auth->user('id'), 'AND' => array('Problem.public' => '1', 'Problem.status' => '6'))), 'order' => 'Problem.modified DESC'));
		$this->set('problems', $problems);
	}

	public function create() {
		$this->setting();
	}

	public function setting($id = null) {
		if($this->request->data) {
			$problem = $this->request->data;
			$problem['Problem']['user_id'] = $this->Auth->user('id');
			$problem['Problem']['status'] = 0;

			$sample_inputs = array();
			$sample_outputs = array();
			for($i = 1; isset($problem['Problem']['sample_input'.$i]) && isset($problem['Problem']['sample_output'.$i]); $i++) {
				$sample_inputs[] = $problem['Problem']['sample_input'.$i];
				$sample_outputs[] = $problem['Problem']['sample_output'.$i];
			}
			$problem['Problem']['sample_inputs'] = json_encode($sample_inputs);
			$problem['Problem']['sample_outputs'] = json_encode($sample_outputs);

			$testcases = array();
			for($i = 1; isset($problem['Problem']['testcase'.$i]); $i++) {
				$testcases[] = $problem['Problem']['testcase'.$i];
			}
			$problem['Problem']['testcases'] = json_encode($testcases);

			if($id) {
				$problem['Problem']['id'] = $id;
				if($this->Problem->save($problem)) {
					$this->redirect('judge/'.$id);
				}
			} else {
				if($this->Problem->save($problem)) {
					$this->redirect('judge/'.$this->Problem->getLastInsertID());
				}
			}
		} else if($id) {
			$problem = $this->Problem->findById($id);
			
			$sample_inputs = json_decode($problem['Problem']['sample_inputs'], true);
			$sample_outputs = json_decode($problem['Problem']['sample_outputs'], true);
			for($i = 1; $i <= min(count($sample_inputs), count($sample_outputs)); $i++) {
				$problem['Problem']['sample_input'.$i] = $sample_inputs[$i - 1];
				$problem['Problem']['sample_output'.$i] = $sample_outputs[$i - 1];
			}
			$testcases = json_decode($problem['Problem']['testcases'], true);
			for($i = 1; $i <= count($testcases); $i++) {
				$problem['Problem']['testcase'.$i] = $testcases[$i - 1];
			}

			$this->request->data = $problem;
			$this->set('problem', $problem);
		}

		$lang = array();
		foreach($this->Language->find('all') as $language) {
			$lang[$language['Language']['id']] = $language['Language']['name'];
		}
		$this->set('lang', $lang);
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
	}

	public function view($id = null) {
		if(!$id) {
			$this->redirect('/');
		}

		$problem = $this->Problem->findById($id);
		$sample_inputs = json_decode($problem['Problem']['sample_inputs'], true);
		$sample_outputs = json_decode($problem['Problem']['sample_outputs'], true);
		$this->set('problem', $problem);
		$this->set('sample_inputs', $sample_inputs);
		$this->set('sample_outputs', $sample_outputs);
	}
}
