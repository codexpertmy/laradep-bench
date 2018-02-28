<?php

namespace Laradep\Tasks;

use Laradep\HasStub;
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
        $nginxPath = $this->config['webserver']['path'] . '/sites-available';
        $logPath = $this->config['webserver']['log_path'];

        $content = str_replace(
            [
                '{{ACCESS_LOG}}',
                '{{ERROR_LOG}}',
                '{{APP_PATH}}',
                '{{FPM_VERSION}}',
            ],
            [
                $logPath . '/' . $this->app,
                $logPath . '/' . $this->app,
                $appPath . '/' . $this->app,
                '7.1',
            ],
            $stub
        );

        file_put_contents(
            $nginxPath . '/' . $this->app
            , $content);

        $symlinkVhost = new Process(
            sprintf(
                'ln -s %s %s',
                $nginxPath . '/' . $this->app,
                $nginxPath . '/sites-enabled'
            )
        );

        $checkNginxConfig = new Process('nginx -t');
        $symlinkVhost->run();
        $checkNginxConfig->run();

        $symlinkVhost->getOutput();
        $checkNginxConfig->getOutput();
    }

    /**
     * @return mixed
     */
    protected function stubPath()
    {
        return $this->config['webserver']['stub_path'];
    }

}
