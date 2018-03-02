<?php

namespace Laradep\Tasks;

use Laradep\Concerns\HasStub;
use Laradep\Tasks\Task;
use Laradep\Tasks\TaskContract;
use Symfony\Component\Process\Process;

class NginxVhostTask extends Task implements TaskContract
{
    use HasStub;

    public function run()
    {
        $this->createVhostConfiguration();
    }

    /**
     * @return mixed
     */
    protected function createVhostConfiguration()
    {
        $stub = $this->getStub('vhost-http');
        $appPath = $this->config['webserver']['app_path'];
        $nginxPath = $this->config['webserver']['path'];
        $logPath = $this->config['webserver']['log_path'];

        $content = str_replace(
            [
                '{{ACCESS_LOG}}',
                '{{ERROR_LOG}}',
                '{{APP_DOMAIN}}',
                '{{APP_PATH}}',
                '{{FPM_VERSION}}',
            ],
            [
                $logPath . '/' . $this->app,
                $logPath . '/' . $this->app,
                $this->app,
                $appPath . '/' . $this->app,
                '7.1',
            ],
            $stub
        );

        file_put_contents(
            $nginxPath . '/sites-available/' . $this->app
            , $content);

        $this->symlinkVhost($nginxPath);
        $this->checkNginxConfig();

    }

    /**
     * @param $configPath
     */
    protected function symlinkVhost($configPath)
    {
        $symlinkVhost = new Process(
            sprintf(
                'ln -s %s %s',
                $configPath . '/sites-available/' . $this->app,
                $configPath . '/sites-enabled'
            )
        );

        try {

            $symlinkVhost->mustRun();
            return $symlinkVhost->getOutput();

        } catch (ProcessFailedException $e) {

            return $e->getMessage();
        }
    }

    /**
     * @return mixed
     */
    protected function checkNginxConfig()
    {
        $checkNginxConfig = new Process('nginx -t');

        try {

            $checkNginxConfig->mustRun();
            return $checkNginxConfig->getOutput();

        } catch (ProcessFailedException $e) {

            return $e->getMessage();
        }

        $checkNginxConfig->run();
    }
    /**
     * @return mixed
     */
    protected function stubPath()
    {
        return $this->config['webserver']['stub_path'];
    }

}
