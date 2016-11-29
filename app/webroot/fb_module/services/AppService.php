<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 11/29/16
 * Time: 8:43 PM
 */

namespace Services;

use Services\DebugService;

class AppService
{
    protected $log;

    public function __construct()
    {
        $this->log = DebugService::getInstance();
    }
}