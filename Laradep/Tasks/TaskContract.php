<?php
namespace Laradep\Tasks;

interface TaskContract
{

    /**
     * @param ControllAble $process
     */
    public function run();
}
