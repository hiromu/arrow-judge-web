<?php
App::uses('AppController', 'Controller');
App::import('Model', 'ConnectionManager');

class InstallController extends AppController {
	public $name = 'Install';
	public $helpers = array('Form');
	public $components = array('Session');
	

	public function beforeFilter() {
		$this->layout = 'install';
		$this->Auth->allow('*');
		$this->Auth->flash['element'] = 'error';
	}

	public function index() {
		$directories = array(APP.'Config'.DS.'core.php', APP.'Config'.DS.'database.php', APP.'Config'.DS.'email.php', APP.'Data'.DS.'Answer'.DS, APP.'Data'.DS.'Output'.DS, APP.'Data'.DS.'Testcase'.DS, TMP, TMP.'cache'.DS, TMP.'logs'.DS.'debug.log', TMP.'logs'.DS.'error.log');

		$writable = array();
		$ok = true;
		foreach($directories as $directory) {
			$writable[$directory] = is_writable($directory);
			$ok &= $writable[$directory];
		}

		$this->set('writable', $writable);
		$this->set('ok', $ok);
	}

	public function secure() {
		$core = file_get_contents(APP.'Config'.DS.'core.php');
		$salt = hash('sha256', openssl_random_pseudo_bytes(100));
		$seed = hexdec(substr(hash('sha256', openssl_random_pseudo_bytes(100)), 0, 15));

		$core = preg_replace('/Configure::write\(\s*\'Security.salt\'\s*,\s*\'\'\s*\)/i', 'Configure::write(\'Security.salt\', \''.$salt.'\')', $core);
		$core = preg_replace('/Configure::write\(\s*\'Security.cipherSeed\'\s*,\s*\'\'\s*\)/i', 'Configure::write(\'Security.cipherSeed\', \''.$seed.'\')', $core);
		file_put_contents(APP.'Config'.DS.'core.php', $core);

		$this->redirect('/database');
	}

	public function database() {
		$path = APP.'Config'.DS.'database.php';

		if($this->request->data) {
			$database = $this->request->data['Database'];
	
			$connection = @mysql_connect($database['host'], $database['login'], $database['password']);
			if($connection) {
				$db = @mysql_select_db($database['database']);
				if($db) {
					$data = <<<EOF
<?php
class DATABASE_CONFIG {
        public \$default = array(
                'datasource' => 'Database/Mysql',
                'persistent' => false,
                'host' => '{$database['host']}',
                'login' => '{$database['login']}',
                'password' => '{$database['password']}',
                'database' => '{$database['database']}',
                'prefix' => '',
                'encoding' => 'utf8',
        );
}
?>
EOF;
					file_put_contents($path, $data);
					$this->redirect('/runsql');
				} else {
					$this->Session->setFlash('Cannot connect to the database: '.mysql_error(), 'error');
				}
			} else {
				$this->Session->setFlash('Cannot connect to the database: '.mysql_error(), 'error');
			}
		} else if(@filesize($path) > 0) {
			$this->Session->setFlash($path.' already exists', 'error');
		}
	}

	public function runsql() {
		$db = ConnectionManager::getDataSource('default');
		if(!$db->isConnected()) {
			$this->redirect('/database');
		}

		$sql = explode(';', file_get_contents(APP.'Config'.DS.'database.sql'));
		foreach($sql as $statement) {
			if(trim($statement) != '') {
				$db->query($statement);
			}
		}

		$this->redirect('/account');
	}

	public function account() {
		if($this->request->data) {
			$this->loadModel('User');

			$this->request->data['User']['active'] = 1;
			$this->request->data['User']['admin'] = 1;
			if($this->User->save($this->request->data)) {
				$this->Auth->login();
				$this->Session->setFlash('Installation was finished', 'success');
				file_put_contents(TMP.DS.'installed', '');
				$this->redirect('/settings');
			}
		}
	}
}
