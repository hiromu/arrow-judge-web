<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class UsersController extends AppController {
	public $name = 'Users';
	public $helpers = array('Form', 'Paginator');
	public $uses = array('User', 'Submission', 'Language');
	public $components = array('Email', 'Session', 'Security' => array('validatePost' => false));
	public $paginate = array('limit' => 50, 'order' => array('Submission.created' => 'desc'));

	public function beforeFilter() {
		$this->Security->blackHoleCallback = 'blackhole';
		parent::beforeFilter();
	}

	public function blackhole() {
		$this->Session->setFlash('Invalid request was detected. Please resubmit.', 'error');
		$this->redirect($this->referer());
	}

	public function index($id = null) {
		if(!$id) {
			$this->redirect('/');
		}

		$user = $this->User->findById($id);
		if(!$user) {
			$this->redirect('/');
		}

		$submissions = $this->paginate('Submission', array('Submission.user_id' => $id, 'Submission.secret' => 0));
		$this->set('user', $user);
		$this->set('submissions', $submissions);

		$languages = $this->Language->find('all', array('conditions' => array('Language.status', 1)));
		$lang = array();
		foreach($languages as $language) {
			$lang[$language['Language']['id']] = $language['Language']['name'];
		}
		$this->set('lang', $lang);
	}

	public function login() {
		if($this->Auth->user()) {
			$this->redirect('/');
		}
		if($this->request->isPost()) {
			if($this->Auth->login()) {
				if($this->Auth->user('active') == '1') {
					$this->redirect($this->Auth->redirect());
				} else {
					$this->Auth->flash('Your account is not yet confirmed');
					$this->logout();
				}
			} else {
				$this->Auth->flash('Invalid username or password, try again');
			}
		}
	}

	public function logout() {
		$this->Session->delete('auth');
		$this->redirect($this->Auth->logout());
	}

	public function register() {
		if($this->Auth->user()) {
			$this->redirect('/');
		}
		if($this->request->isPost() || $this->request->isPut()) {
			$rand = md5(uniqid(rand(), 1));
			$this->request->data['User']['confirm'] = $rand;
			if($this->User->save($this->request->data)) {
				$contest = array();
				$content['username'] = $this->request->data['User']['username'];
				$content['url'] = Router::url('confirm', true).'/'.$rand;
				$content['top_page'] = Router::url('/', true);
				$content['title'] = $this->options['title'];

				$email = new CakeEmail('smtp');
				$email->template('register', 'default');
				$email->viewVars($content);
				$email->to($this->request->data['User']['email']);
				$email->from($this->options['email_address']);
				$email->subject($this->options['title'].': '.'Registration Confirmation');
				$email->send();

				$this->Session->setFlash('Please click on the link in an email send for your email address.', 'success');
			}
		}
	}

	public function confirm($id = null) {
		if(!$id) {
			$this->redirect('/');
		}

		$userdata = $this->User->find('first', array('conditions' => array('User.confirm' => $id)));
		if($userdata) {
			$userdata['User']['active'] = 1;
			$userdata['User']['confirm'] = md5(uniqid(rand(), 1));
			$this->User->save($userdata, true, array('active', 'confirm'));
		} else {
			$this->redirect('/');
		}
	}

	public function request() {
		if($this->Auth->user()) {
			$this->redirect('/');
		}

		if($this->request->data) {
			$user = $this->User->find('first', array('conditions' => array('User.email' => $this->request->data['User']['username'])));
			if(!$user) {
				$user = $this->User->find('first', array('conditions' => array('User.username' => $this->request->data['User']['username'])));
			}

			if(!$user) {
				$this->Session->setFlash($this->request->data['User']['username'].' was not found', 'error');
			} else {
				$rand = md5(uniqid(rand(), 1));
				$user['User']['confirm'] = $rand;
				if($this->User->save($user, false, array('confirm'))) {
					$contest = array();
					$content['username'] = $user['User']['username'];
					$content['url'] = Router::url('reset', true).'/'.$rand;
					$content['top_page'] = Router::url('/', true);
					$content['title'] = $this->options['title'];

					$email = new CakeEmail('smtp');
					$email->template('reset', 'default');
					$email->viewVars($content);
					$email->to($user['User']['email']);
					$email->from($this->options['email_address']);
					$email->subject($this->options['title'].': '.'Password Reset Confirmation');
					$email->send();

					$this->Session->setFlash('Please click on the link in an email send for your email address.', 'success');
				}
			}
		}
	}

	public function reset($id = null) {
		if(!$id) {
			$this->redirect('/');
		}

		$user = $this->User->find('first', array('conditions' => array('User.confirm' => $id)));
		if(!$user) {
			$this->redirect('/');
		}

		if($this->request->data) {
			$user['User']['confirm'] = md5(uniqid(rand(), 1));
			$user['User']['password'] = $this->request->data['User']['password'];
			$user['User']['confirm_password'] = $this->request->data['User']['confirm_password'];

			if($this->User->save($user)) {
				$this->Session->setFlash('Your password was changed successfully.', 'success');
				$this->redirect('login');
			}
		}
	}

	public function setting() {
		if(!$this->Auth->user()) {
			$this->redirect('/');
		}

		$id = $this->Auth->user('id');
		if($this->request->data) {
			$this->request->data['User']['id'] = $id;
			if($this->User->save($this->request->data)) {
				$user = $this->User->findById($id);
				unset($user['User']['password']);
				$this->Session->write('Auth', $user);
				$this->Session->setFlash('User settings are updated', 'success');
			}
		} else {
			$user = $this->User->findById($id);
			unset($user['User']['password']);
			$this->request->data = $user;
		}
	}
}
