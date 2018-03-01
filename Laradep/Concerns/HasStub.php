<?php
namespace Laradep\Concerns;

use Laradep\Config;

trait HasStub
{

    /**
     * @param $path
     */
    protected function getStub($name = null)
    {
        if (method_exists($this, 'stubPath')) {
            return file_get_contents(
                $this->stubPath() . '/' . $name . '.stub'
            );
        }

        return file_get_contents($name);
    }
}
