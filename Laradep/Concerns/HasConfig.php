<?php
namespace Laradep\Concerns;

use Laradep\Config;

trait HasConfig
{

    public function instance()
    {
        return (new Config);
    }
}
