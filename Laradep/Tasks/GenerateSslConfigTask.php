<?php

namespace Laradep\Tasks;

use Laradep\Concerns\HasStub;
use Laradep\Tasks\Task;
use Laradep\Tasks\TaskContract;
use Symfony\Component\Process\Process;

class GenerateSslConfigTask extends Task implements TaskContract
{
    use HasStub;

    /**
     * @var int
     */
    protected static $dhParamLength = 2048;

    /**
     * @var string
     */
    protected static $output = 'dhparam.pem';

    /**
     * @var string
     */
    protected static $dhParamPath = '/etc/ssl/certs/';

    /**
     * @var string
     */
    protected static $prefix = 'ssl-';

    public function run()
    {
        $this->generate();
    }

    protected function generate()
    {
        if (!self::doesSslDhParamExist()) {
            self::generateDhParam();
        }

        $this->letEncryptCommand();
        $this->copySslSnippetConfig();

    }

    protected function generateDhParam()
    {
        return exec(
            sprintf(
                'openssl dhparam -out %s %s',
                static::$getDhParamFile(),
                static::$dhParamLength
            )
        );
    }

    protected function letEncryptCommand()
    {
        return exec(
            sprintf(
                'certbot certonly --webroot --agree-tos --no-eff-email --email %s -w %s -d %s',
                $this->getUserEmail(),
                $this->getProjetPath() . $this->app . '/' . 'public',
                $this->app
            )
        );
    }

    /**
     * @return mixed
     */
    protected function copySslSnippetConfig(): bool
    {
        $loadStub = $this->getStub('ssl-domain');
        $content = str_replace('{{DOMAIN}}', $this->app, $loadStub);
        return file_put_contents(
            $this->getSnippetPath() . '/' . $this->getFilename(),
            $content
        );
    }

    /**
     * @return mixed
     */
    protected function getSnippetPath()
    {
        return $this->config['webserver']['path'] . '/' . 'snippets';
    }

    /**
     * @return mixed
     */
    protected function doesSslDhParamExist()
    {
        return $this->fileAlreadyExist(
            self::$dhParamPath,
            self::$output
        );
    }

    protected function stubPath()
    {
        return base_path('assets/webservers/nginx');
    }

    /**
     * get full name of domain config file name
     * @return String filename
     */
    private function getFilename()
    {
        return self::$prefix . $this->app . '.conf';
    }

    protected static function getDhParamFile()
    {
        return static::$dhParamPath . static::$output;
    }
}
