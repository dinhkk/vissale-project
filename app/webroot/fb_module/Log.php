<?php

/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 10/22/16
 * Time: 5:15 PM
 */

require_once dirname(__FILE__) . '/src/core/config.php';
require_once("vendor/autoload.php");

class Log
{
    public $log;

    public function __construct($level)
    {
        $this->log = null;

        if ($level == "error") {
            $this->log = new Katzgrau\KLogger\Logger( APP_PATH .'/logs/', Psr\Log\LogLevel::DEBUG ,array(
                'filename' => "error_"  . date("Y-m-d_H"),
            ));
        }

        if ($level == "debug") {
            $this->log = new Katzgrau\KLogger\Logger( APP_PATH .'/logs/', Psr\Log\LogLevel::DEBUG ,array(
                'filename' => "debug_"  . date("Y-m-d_H"),
            ));
        }

        if (!in_array($level, array("error", "debug"))) {
            $this->log = new Katzgrau\KLogger\Logger( APP_PATH .'/logs/', Psr\Log\LogLevel::DEBUG ,array(
                'filename' => "log_"  . date("Y-m-d_H"),
            ));
        }

        //return $this;
    }

    public function getLogObject()
    {
        return $this->log;
    }
}