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

class QuestionsController extends AppController {
	public $name = 'Questions';
	public $helpers = array('Form');
	public $uses = array('Problem', 'Question');
	public $components = array('Email', 'Session');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('*');
		$this->Auth->allow('index');
		$this->Auth->flash['element'] = 'error';
	}

	public function index($id = null, $contest_id = null) {
		if(!$id) {
			$this->redirect('/problems/index');
		}

		$problem = $this->Problem->findById($id);
		if(!$problem) {
			$this->redirect('/problems/index');
		}
		$this->set('problem', $problem);
		$this->set('contest_id', $contest_id);

		if($this->request->data) {
			if(!$this->Auth->user('id')) {
				$this->Session->setFlash('You are not permitted to post question');
			} else {
				if($problem['Problem']['user_id'] == $this->Auth->user('id')) {
					$this->redirect('/problems/index');
				}
				$this->request->data['Question']['user_id'] = $this->Auth->user('id');
				$this->request->data['Question']['problem_id'] = $id;
				$this->request->data['Question']['public'] = 2;
				if($this->Question->save($this->request->data)) {
					$this->set('problem', $problem);
					$this->set('question', $this->request->data['Question']['question']);
					$this->set('url', Router::url('answer', true).'/'.$this->Question->getLastInsertID().'/'.$contest_id);
					$this->Email->transport = 'Smtp';
					$this->Email->to = $problem['User']['email'];
					$this->Email->from = $this->options['email_address'];
					$this->Email->subject = $this->options['title'].': '.'You recieved a new question';
					$this->Email->template = 'question';
					$this->Email->send();
	
					$this->redirect('index/'.$id.'/'.$contest_id);
				}
			}
		} else {
			if($problem['Problem']['user_id'] == $this->Auth->user('id')) {
				$unanswered = $this->Question->find('all', array('conditions' => array('Question.problem_id' => $id, 'Question.public' => 2),  'order' => 'Question.created DESC'));
			} else {
				$unanswered = $this->Question->find('all', array('conditions' => array('Question.problem_id' => $id, 'Question.public' => 2, 'Question.user_id' => $this->Auth->user('id')),  'order' => 'Question.created DESC'));
			}
			$this->set('unanswered', $unanswered);

			if($this->Auth->user('id')) {
				$questions = $this->Question->find('all', array('conditions' => array('AND' => array('Question.problem_id' => $id, 'OR' => array('Question.public' => 0, 'AND' => array('Question.public' => 1, 'OR' => array('Question.user_id' => $this->Auth->user('id'), 'Problem.user_id' => $this->Auth->user('id')))))),  'order' => 'Question.created DESC'));
			} else {
				$questions = $this->Question->find('all', array('conditions' => array('Question.problem_id' => $id, 'Question.public' => 0),  'order' => 'Question.created DESC'));
			}
			$this->set('questions', $questions);
		}
	}

	public function answer($id = null, $contest_id = null) {
		if(!$id) {
			$this->redirect('/problems/index');
		}

		$question = $this->Question->findById($id);
		if(!$question) {
			$this->redirect('/problems/index');
		}
		if($question['Problem']['user_id'] != $this->Auth->user('id')) {
			$this->redirect('index/'.$id.'/'.$contest_id);
		}
		if($question['Question']['public'] != 2) {
			$this->redirect('index/'.$id.'/'.$contest_id);
		}

		if($this->request->data) {
			$this->request->data['Question']['id'] = $id;
			if($this->Question->save($this->request->data)) {
				$this->set('question', $question);
				$this->set('answer', $this->request->data['Question']['answer']);
				$this->set('url', Router::url('index', true).'/'.$question['Problem']['id'].'/'.$contest_id);
				$this->Email->transport = 'Smtp';
				$this->Email->to = $question['User']['email'];
				$this->Email->from = $this->options['email_address'];
				$this->Email->subject = $this->options['title'].': '.'Your question was answered';
				$this->Email->template = 'answered';
				$this->Email->send();

				$this->redirect('index/'.$question['Problem']['id'].'/'.$contest_id);
			}
		}

		$this->set('contest_id', $contest_id);
		$this->set('question', $question);
	}

	public function remove($id = null, $contest_id = null) {
		if(!$id) {
			$this->redirect('/problems/index');
		}

		$question = $this->Question->findById($id);
		if(!$question) {
			$this->redirect('/problems/index');
		}
		if($question['Problem']['user_id'] != $this->Auth->user('id')) {
			$this->redirect('index/'.$id.'/'.$contest_id);
		}
		if($question['Question']['public'] != 2) {
			$this->redirect('index/'.$id.'/'.$contest_id);
		}

		if($this->request->data) {
			$this->request->data['Question']['id'] = $id;
			$this->request->data['Question']['public'] = 3;
			if($this->Question->save($this->request->data)) {
				$this->redirect('index/'.$question['Problem']['id'].'/'.$contest_id);
			}
		}

		$this->set('contest_id', $contest_id);
		$this->set('question', $question);
	}
}
