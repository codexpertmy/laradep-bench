<?php

namespace Laradep;

use Symfony\Component\Yaml\Yaml;

class Config
{
    /**
     * @var array
     */
    protected $attributes = [];

    public function __construct()
    {
        $this->loadConfig();
    }

    /**
     * @param $customPath
     */
    protected function loadConfig($customPath = null)
    {
        if (!is_null($customPath)) {
            return $this->attributes = Yaml::parseFile($customPath);
        }

        return $this->attributes = Yaml::parseFile(base_path('laradep.yaml'));

    }

    /**
     * @return mixed
     */
    public function config()
    {
        return $this->attributes;
    }

    public function __toString()
    {
        return json_encode($this->attributes);
    }
}
