<?php

namespace Laradep\Tasks;

use Laradep\Concerns\HasConfig;
use Laradep\Concerns\HasUtility;

abstract class Task
{
    use HasConfig, HasUtility;

    /**
     * @var mixed
     */
    protected $config;

    /**
     * @var mixed
     */
    protected $app;
    /**
     * @param $app
     */
    public function __construct($app = null)
    {
        $this->app = $app;
        $this->config = $this->instance()->config();
    }

    /**
     * @return mixed
     */
    protected function getProjectPath()
    {
        return $this->config['webserver']['app_path'] . DIRECTORY_SEPARATOR;
    }
}
