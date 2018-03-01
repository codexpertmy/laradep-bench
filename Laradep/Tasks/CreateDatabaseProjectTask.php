<?php

namespace Laradep\Tasks;

use Laradep\Concerns\HasStub;
use Laradep\Tasks\Task;
use Laradep\Tasks\TaskContract;
use Symfony\Component\Process\Process;

class CreateDatabaseProjectTask extends Task implements TaskContract
{
    use HasStub;

    /**
     * @var string
     */
    protected $enviroment = '.env';

    /**
     * @var string
     */
    protected $exampleEnviroment = '.env.example';

    public function run()
    {
        $this->setupDatabase();
    }

    protected function setupDatabase()
    {
        //generate random password
        echo 'setup database done.' . $this->getProjectPath() . $this->app . '/' . $this->enviroment;
        echo $this->getDatabaseUser();
    }

    /**
     * @return mixed
     */
    protected function getDatabaseUser(): string
    {
        return $this->config['database']['username'];
    }

    /**
     * @return mixed
     */
    protected function getDatabasePassword(): string
    {
        return $this->config['database']['password'];
    }

    /**
     * @return mixed
     */
    protected function getDatabaseHost(): string
    {
        return $this->config['database']['host'];
    }

    protected function checkEnvironmentFile(): void
    {
        if (!$this->fileAlreadyExist($this->getProjectPath() . $this->app . '/' . $this->enviroment)) {
            $this->copyEnvironmentFile();
        }
    }

    protected function copyEnvironmentFile()
    {
        return exec(
            sprintf('cp %s %s',
                $this->getProjectPath() . $this->app . '/' . $this->exampleEnviroment,
                $this->getProjectPath() . $this->app . '/' . $this->enviroment
            )
        );
    }
}
