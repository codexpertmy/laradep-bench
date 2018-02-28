<?php

namespace Laradep\Tasks;

use Laradep\Tasks\Task;
use Laradep\Tasks\TaskContract;
use Symfony\Component\Process\Process;

class LoggingTask extends Task implements TaskContract
{
    /**
     * @var array
     */
    protected $logsFile = [
        'error',
        'access',
        'queue',
        'supervisor',
        'socket-io',
    ];

    public function run()
    {
        $this->setupLogDirectory();
        $this->createLogsFile();
    }

    public function setupLogDirectory()
    {
        return !is_dir($this->getLogPath()) ? $this->createLogDirectory($this->getLogPath()) : false;
    }

    protected function createLogsFile()
    {
        foreach ($this->logsFile as $logFile) {
            touch($this->getLogPath() . '/' . $logFile . '.log');
        }
    }

    /**
     * @return mixed
     */
    protected function getLogPath()
    {
        if (isset($this->config['webserver']['log_path'])) {

            return $this->config['webserver']['log_path'] . '/' . $this->app;
        }

        throw new Exception('config log_path are not found.');
    }

    /**
     * @param $path
     */
    protected function createLogDirectory($path)
    {
        return mkdir($path, 0755, true);
    }
}
