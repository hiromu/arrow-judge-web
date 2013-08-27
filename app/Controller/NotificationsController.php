<?php
App::uses('AppController', 'Controller');

class NotificationsController extends AppController {
	public $name = 'Notifications';
	public $helpers = array('Form');
	public $uses = array('Contest', 'Notification');
	public $components = array('Session');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('*');
		$this->Auth->flash['element'] = 'error';
	}

	public function index($contest_id = null) {
		if(!$contest_id || !$this->Auth->user('admin')) {
			$this->redirect('/contests');
		}

		$contest = $this->Contest->findById($contest_id);
		if(!$contest) {
			$this->redirect('/contests');
		}

		$this->set('contest_id', $contest_id);
		$this->set('notifications', $this->Notification->find('all', array('conditions' => array('Notification.active' => '1'), 'order' => 'Notification.created ASC')));
	}

	public function add($contest_id = null) {
		if(!$contest_id || !$this->Auth->user('admin')) {
			$this->redirect('index');
		}

		$contest = $this->Contest->findById($contest_id);
		if(!$contest) {
			$this->redirect('index');
		}

		if($this->request->data) {
			$this->request->data['Notification']['contest_id'] = $contest_id;
			if($this->Notification->save($this->request->data)) {
				$this->redirect('index/'.$contest_id);
			}
		}

		$this->set('contest_id', $contest_id);
	}

	public function delete($id = null, $contest_id = null) {
		if(!$id || !$contest_id || !$this->Auth->user('admin')) {
			$this->redirect('index');
		}

		$contest = $this->Contest->findById($contest_id);
		if(!$contest) {
			$this->redirect('index');
		}
		$notification = $this->Notification->findById($id);
		if(!$notification) {
			$this->redirect('index');
		}

		if($this->request->data) {
			if($this->request->data['Notification']['id'] == $id) {
				$this->request->data['Notification']['active'] = 0;
				if($this->Notification->save($this->request->data)) {
					$this->redirect('index/'.$contest_id);
				} else {
					$this->Session->setFlash(sprintf('Failed to delete the notification'));
				}
			}
		}

		$this->set('contest_id', $contest_id);
		$this->set('notification', $notification);
	}
}
