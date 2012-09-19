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
	public $uses = array('Problem', 'Submission', 'Language');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('*');
		$this->Auth->allow('index');
		$this->Auth->flash['element'] = 'error';
	}

	public function index() {
		$submissions = $this->Submission->find('all', array('limit' => '100', 'order' => 'Submission.created DESC'));
		$this->set('submissions', $submissions);
	}

	public function detail($id = null) {
		if(!$id) {
			$this->redirect('/');
		}

		$submission = $this->Submission->findById($id);
		if(!$submission || $submission['Submission']['user_id'] != $this->Auth->user('id')) {
			$this->redirect('/');
		}

		$this->set('submission', $submission);
		$this->set('input', json_decode($submission['Problem']['testcases']));
		$this->set('output', json_decode($submission['Submission']['output']));
		$this->set('cpu', json_decode($submission['Submission']['cpu']));
		$this->set('memory', json_decode($submission['Submission']['memory']));
	}

	public function submit($id = null) {
		if(!$id) {
			$this->redirect('/');
		}

		$problem = $this->Problem->findById($id);
		if(!$problem) {
			$this->redirect('/');
		}

		if($this->request->data) {
			$this->request->data['Submission']['user_id'] = $this->Auth->user('id');
			$this->request->data['Submission']['problem_id'] = $id;
			if($this->Submission->save($this->request->data)) {
				$this->redirect('index');
			}
		}

		$languages = $this->Language->find('all');
		$lang = array();
		foreach($languages as $language) {
			$lang[$language['Language']['id']] = $language['Language']['name'];
		}
		$this->set('lang', $lang);
		$this->set('problem', $problem);
	}
}
