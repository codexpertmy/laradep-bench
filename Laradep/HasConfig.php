<?php
namespace Laradep;

use Laradep\Config;

trait HasConfig
{

    public function instance()
    {
        return (new Config);
    }
}
