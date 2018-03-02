<?php

namespace Laradep\Tasks;

use Laradep\Tasks\Manageable;

class Redis implements Manageable
{

    public function start()
    {
        return (new Process('service redis-server start'))->run();
    }

    public function restart()
    {
        return (new Process('service redis-server restart'))->run();

    }

    public function stop()
    {
        return (new Process('service redis-server stop'))->run();
    }

    public function __toString()
    {
        return strtolower(get_class());
    }
}
