<?php
App::uses('AppController', 'Controller');

class ServersController extends AppController {
	public $name = 'Servers';
	public $helpers = array('Form');
	public $uses = array('Server');
	public $components = array('Session');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('*');
		$this->Auth->allow('add');
		$this->Auth->flash['element'] = 'error';
	}

	public function index() {
		if(!$this->Auth->user('admin')) {
			$this->redirect('/');
		}

		$deny = $this->Server->find('all', array('conditions' => array('Server.status' => '0'), 'order' => 'Server.created DESC'));
		$allow = $this->Server->find('all', array('conditions' => array('Server.status' => '1'), 'order' => 'Server.created DESC'));

		$this->set('allow', $allow);
		$this->set('deny', $deny);
	}

	public function add() {
		if($this->request->data) {
			$client = $this->request->data;
			$client['Server']['address'] = $this->request->clientIp();

			if($this->Server->save($client)) {
				$this->layout = 'ajax';
			} else {
				throw new NotFoundException();
			}
		} else {
			throw new NotFoundException();
		}
	}

	public function enable($id = null) {
		if(!$this->Auth->user('admin')) {
			$this->redirect('/');
		} else if(!$id) {
			$this->redirect('index');
		}

		$server = $this->Server->findById($id);
		if(!$server || $server['Server']['status'] != 0) {
			$this->redirect('index');
		}

		$server['Server']['status'] = 1;
		if(!$this->Server->save($server)) {
			$this->Session->setFlash(sprintf('Failed to enable %s (%s)', $server['Server']['hostname'], $server['Server']['address']), 'error');
		}

		$this->redirect('index');
	}

	public function disable($id = null) {
		if(!$this->Auth->user('admin')) {
			$this->redirect('/');
		} else if(!$id) {
			$this->redirect('index');
		}

		$server = $this->Server->findById($id);
		if(!$server || $server['Server']['status'] != 1) {
			$this->redirect('index');
		}

		$server['Server']['status'] = 0;
		if(!$this->Server->save($server)) {
			$this->Session->setFlash(sprintf('Failed to enable %s (%s)', $server['Server']['hostname'], $server['Server']['address']), 'error');
		}

		$this->redirect('index');
	}

	public function delete($id = null) {
		if(!$this->Auth->user('admin')) {
			$this->redirect('/');
		} else if(!$id) {
			$this->redirect('index');
		}

		$server = $this->Server->findById($id);
		if(!$server) {
			$this->redirect('index');
		}

		if($this->request->data) {
			if($this->request->data['Server']['id'] == $id) {
				$this->Server->delete($id);
				$this->redirect('index');
			}
		}

		$this->set('server', $server);
	}
}
