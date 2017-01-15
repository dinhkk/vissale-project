<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 1/14/17
 * Time: 9:07 AM
 */

namespace Services;


class CommentGearmanClient
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

    public static function getInstance($server = '127.0.0.1', $port = 4730, $queue = 'log') {
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

    public function __construct($queue, $server, $port) {
        $this->gmc   = new GearmanClient();
        $this->queue = $queue;
        $this->gmc->addServer($server, $port);
    }
}