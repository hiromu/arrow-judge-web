<?php
App::uses('AppController', 'Controller');

class LanguagesController extends AppController {
	public $name = 'Languages';
	public $helpers = array('Form');
	public $uses = array('Language');
	public $components = array('Session');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('*');
		$this->Auth->flash['element'] = 'error';
	}

	public function index() {
		if(!$this->Auth->user('admin')) {
			$this->redirect('/');
		}

		$languages = $this->Language->find('all', array('conditions' => array('Language.status', 1), 'order' => 'Language.id ASC'));
		$this->set('languages', $languages);
	}

	public function create() {
		if(!$this->Auth->user('admin')) {
			$this->redirect('/');
		}

		if($this->request->data) {
			if($this->Language->save($this->request->data)) {
				$this->Session->setFlash('Setting was created successfully', 'success');
				$this->redirect('edit/'.$this->Language->getLastInsertID());
			}
		}
	}

	public function edit($id = null) {
		if(!$this->Auth->user('admin')) {
			$this->redirect('/');
		} else if(!$id) {
			$this->redirect('index');
		}

		$language = $this->Language->findById($id);
		if(!$language || $language['Language']['status'] != 1) {
			$this->redirect('index');
		}

		if($this->request->data) {
			$this->request->data['Language']['id'] = $id;
			if($this->Language->save($this->request->data)) {
				$this->Session->setFlash('Setting was updated successfully', 'success');
			}
		} else {
			$this->request->data = $language;
		}
	}

	public function delete($id = null) {
		if(!$this->Auth->user('admin')) {
			$this->redirect('/');
		} else if(!$id) {
			$this->redirect('index');
		}

		$language = $this->Language->findById($id);
		if(!$language) {
			$this->redirect('index');
		}

		if($this->request->data) {
			if($this->request->data['Language']['id'] == $id) {
				$language['Language']['status'] = 0;
				if($this->Language->save($language)) {
					$this->redirect('index');
				} else {
					$this->Session->setFlash(sprintf('Failed to delete %s', $language['Language']['detail']), 'error');
				}
			}
		}

		$this->set('language', $language);
	}
}
