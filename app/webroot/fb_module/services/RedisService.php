<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 11/30/16
 * Time: 10:10 AM
 */

namespace Services;

use Redis;

class RedisService
{
    private $redis;
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
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1');
        $this->redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
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


    public function redisSet($key, $value)
    {
        $this->redis->set($key, $value);
    }

    public function redisGet($key)
    {
        return $this->redis->get($key);
    }
}