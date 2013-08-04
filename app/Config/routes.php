<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
if(file_exists(TMP.'installed')) {
	Router::connect('/', array('controller' => 'App', 'action' => 'index'));
	CakePlugin::routes();
	require CAKE . 'Config' . DS . 'routes.php';
} else {
	Router::connect('/', array('controller' => 'Install', 'action' => 'index'));
	Router::connect('/secure', array('controller' => 'Install', 'action' => 'secure'));
	Router::connect('/database', array('controller' => 'Install', 'action' => 'database'));
	Router::connect('/runsql', array('controller' => 'Install', 'action' => 'runsql'));
	Router::connect('/account', array('controller' => 'Install', 'action' => 'account'));
}
