<?php

namespace Laradep\Tasks;

use Laradep\Exceptions\AppAlreadyExistException;
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

    /**
     * @return mixed
     */
    public function setupLogDirectory()
    {
        if ($this->folderAlreadyExist($this->getLogPath())) {
            throw new AppAlreadyExistException(
                sprintf('logging folder with %s name already exists.', $this->app)
            );

        }
        return $this->createLogDirectory($this->getLogPath());
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
