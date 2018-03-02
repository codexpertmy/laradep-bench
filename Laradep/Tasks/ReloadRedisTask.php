<?php

namespace Laradep\Tasks;

use Laradep\HasStub;
use Laradep\Tasks\Task;
use Laradep\Tasks\TaskContract;
use Symfony\Component\Process\Process;

class ReloadRedisTask extends Task implements TaskContract
{
    use HasStub;

    /**
     * @param ControllAble $redis
     */
    public function run()
    {
        if ($this->redisInstalled()) {
            //$redis->start();
        }
    }
}
