<?php

namespace Joelvardy;

use \Symfony\Component\Yaml\Yaml;

class Config
{

    protected static $config = false;

    public static function get($key)
    {

        if (!self::$config) {
            // We JSON encode then JSON decode to convert arrays to objects
            self::$config = json_decode(json_encode(Yaml::parse(file_get_contents(dirname(__DIR__) . '/config.yml'))));
        }

        if (!isset(self::$config->$key)) {
            return false;
        }

        return self::$config->$key;

    }

}
