<?php
namespace Laradep\Tasks;

interface Manageable
{
    public function start();

    public function restart();

    public function stop();
}
