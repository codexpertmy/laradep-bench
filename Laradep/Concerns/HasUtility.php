<?php

namespace Laradep\Concerns;

trait HasUtility
{
    /**
     * @param $path
     * @param $file
     */
    public function fileAlreadyExist($path, $file): bool
    {
        return file_exists($path . $file) ?: false;
    }

    /**
     * @param $path
     */
    public function folderAlreadyExist($path): bool
    {
        return is_dir($path) ?: false;
    }

    public function generateRandomPassword(): string
    {

    }

    /**
     * @return mixed
     */
    public function redisInstalled()
    {
        $process = new Process('redis-server --version');
        try {
            $process->mustRun();
            return true;

        } catch (ProcessFailedException $e) {

            return false;
        }
    }
}
