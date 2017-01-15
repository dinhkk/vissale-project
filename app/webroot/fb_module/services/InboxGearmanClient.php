<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 1/14/17
 * Time: 9:00 AM
 */

namespace Services;

use GearmanClient;

class InboxGearmanClient
{
    static $instances = array();

    /**
     * Fetch (and create if needed) an instance of this logger.
     *
     * @param string $server
     * @param int $port
     * @param string $queue default log system
     * @return self
     *
     */

    public static function getInstance($queue = null) {
        if ($queue == null) {
            return null;
        }

        $server = self::$server;
        $port = self::$port;

        $hash = $queue . $server . $port;
        if (!array_key_exists($hash, self::$instances)) {
            self::$instances[$hash] = new self($queue, $server, $port);
        }

        return self::$instances[$hash];
    }

    /** @var GearmanClient */
    private $gmc;
    /** @var string */
    private $queue;
    private static $server = '127.0.0.1';
    private static $port = 4730;


    public function __construct($queue) {
        $this->gmc   = new GearmanClient();
        $this->queue = $queue;
        $this->gmc->addServer(self::$server, self::$port);
    }


    public function delivery(Array $dada)
    {
        return $this->gmc->doBackground( $this->queue, json_encode($dada) );
    }
}

