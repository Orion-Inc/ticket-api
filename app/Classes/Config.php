<?php
    namespace oTikets\Classes;
    use Monolog;

    define('ROOT', __DIR__.'/../../config/');

    class Config extends App
    {
        public static function configuration($mode)
        {
            return json_decode(file_get_contents(ROOT.$mode.'.json'),true);
        }
    }