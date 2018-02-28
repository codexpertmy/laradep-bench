<?php

use Laradep\Config;
use Laradep\Tasks\LoggingTask;
use Laradep\Tasks\NginxVhostTask;

require_once 'bootstrap.php';

$task = new NginxVhostTask('codexpert.my');
echo $task->run();
