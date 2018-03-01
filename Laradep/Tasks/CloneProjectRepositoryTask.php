<?php

namespace Laradep\Tasks;

use Laradep\Concerns\HasConfig;
use Laradep\Concerns\HasStub;
use Laradep\Concerns\HasUtility;
use Laradep\Tasks\Task;
use Laradep\Tasks\TaskContract;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class CloneProjectRepositoryTask extends Task implements TaskContract
{
    use HasStub, HasUtility;

    /**
     * @var mixed
     */
    protected $repository;

    /**
     * @return mixed
     */
    public function run()
    {
        $this->cloneProjectRepository();
        if (!$this->folderAlreadyExist($this->getProjectPath() . $this->app())) {
            $this->composerInstall();
        }
    }

    /**
     * @param  $repository
     * @return mixed
     */
    public function setupRepository($repository)
    {
        $this->repository = $repository;
        return $this;
    }

    protected function composerInstall()
    {
        return exec(
            sprintf(
                'composer install -d %s',
                $this->getProjectPath() . $this->app
            ));
    }

    protected function cloneProjectRepository()
    {
        return exec(
            sprintf('git clone %s %s -vv',
                $this->repository,
                $this->getProjectPath() . $this->app
            ));
    }

    /**
     * @return mixed
     */
    protected function getProjectPath()
    {
        return $this->config['webserver']['app_path'] . DIRECTORY_SEPARATOR;
    }

}
