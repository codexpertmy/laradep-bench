<?php

namespace Laradep\Tasks;

use Laradep\HasConfig;

abstract class Task
{
    use HasConfig;

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
}
