<?php

/* Optional. It’s better to do it in the php.ini file */
date_default_timezone_set('Europe/Amsterdam');

// include the composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use Commands\PaydayCommand;

// Create app, add commands and execute it
$app = new Application();
$app->add(new PaydayCommand());
$app->run();
