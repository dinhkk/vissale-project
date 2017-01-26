<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 11/29/16
 * Time: 8:15 PM
 */

namespace Services;

use Katzgrau\KLogger\Logger;

//singleton debug class

class DebugService
{
    /**
     * @var Singleton The reference to *Singleton* instance of this class
     */
    private static $instance;

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Singleton The *Singleton* instance.
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {
    }

    public function debug($message, $extra = [])
    {
        if (APP_ENV == "production") {
            //return false;
        }

        return (new \Katzgrau\KLogger\Logger(APP_PATH . '/logs/', \Psr\Log\LogLevel::DEBUG, array(
            'filename' => "debug_" . date("Y-m-d_H"),
        )))->debug($message, $extra);
    }

    public function error($message, $extra = [])
    {
        return (new \Katzgrau\KLogger\Logger(APP_PATH . '/logs/', \Psr\Log\LogLevel::DEBUG, array(
            'filename' => "error_" . date("Y-m-d_H"),
        )))->error($message, $extra);
    }
}