<?php

class autoloader
{
    public static $files;

    /*
     * Register all file we used namespace for project
     */
    public static function register() {
        foreach(autoloader::$files as $directory) {
            if(file_exists($directory . '.php')) {
                require_once($directory . '.php');
            }
        }
    }
}

?>