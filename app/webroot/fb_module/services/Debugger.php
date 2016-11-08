<?php

/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 10/22/16
 * Time: 5:15 PM
 */

namespace Services;

use Katzgrau\KLogger\Logger;

class Debugger
{
    public $log;

    public function __construct()
    {

    }

    public function getLogObject($level)
    {
        $this->log = null;

        if ($level == "error") {
            $this->log = new \Katzgrau\KLogger\Logger(APP_PATH . '/logs/', \Psr\Log\LogLevel::DEBUG, array(
                'filename' => "error_"  . date("Y-m-d_H"),
            ));
        }

        if ($level == "debug") {
            $this->log = new \Katzgrau\KLogger\Logger(APP_PATH . '/logs/', \Psr\Log\LogLevel::DEBUG, array(
                'filename' => "debug_"  . date("Y-m-d_H"),
            ));
        }

        if (!in_array($level, array("error", "debug"))) {
            $this->log = new \Katzgrau\KLogger\Logger(APP_PATH . '/logs/', \Psr\Log\LogLevel::DEBUG, array(
                'filename' => "log_"  . date("Y-m-d_H"),
            ));
        }

        return $this->log;
    }
}