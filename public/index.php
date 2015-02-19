<?php
//ensure all includes/requires are from the project root
chdir(dirname(__DIR__));
require('vendor/autoload.php');
//start the app
Zend\Mvc\Application::init(require 'config/application.config.php')->run();