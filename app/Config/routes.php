<?php
if(file_exists(TMP.'installed')) {
	Router::connect('/', array('controller' => 'App', 'action' => 'index'));
	CakePlugin::routes();
	require CAKE . 'Config' . DS . 'routes.php';
} else {
	Router::connect('/', array('controller' => 'Install', 'action' => 'index'));
	Router::connect('/secure', array('controller' => 'Install', 'action' => 'secure'));
	Router::connect('/database', array('controller' => 'Install', 'action' => 'database'));
	Router::connect('/runsql', array('controller' => 'Install', 'action' => 'runsql'));
	Router::connect('/email', array('controller' => 'Install', 'action' => 'email'));
	Router::connect('/account', array('controller' => 'Install', 'action' => 'account'));
}
