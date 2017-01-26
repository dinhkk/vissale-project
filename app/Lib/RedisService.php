<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 11/30/16
 * Time: 10:10 AM
 */

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
        $this->redis->pconnect('127.0.0.1', 6379, 1);
        $this->redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
        $this->redis->setOption(Redis::OPT_SCAN, Redis::SCAN_RETRY);
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


    /**
     * @param $key
     * @param $value
     * @param $ttl
     * $ttl is seconds of time to live, 1hour for default
     */
    public function set($key, $value, $ttl = 3600)
    {
        $this->redis->setex($key, $ttl, $value);
    }

    /**
     * @param $key
     * @return bool|string
     */
    public function get($key)
    {
        return $this->redis->get($key);
    }

    /**
     * @return bool
     */
    public function clearAll()
    {
        return $this->redis->flushAll();
    }


    public function deleteKeys(Array $keys)
    {
        return $this->redis->delete( $keys );
    }

    public function getGroupPrefix($group_id)
    {
         return !empty($group_id) ? "_group_" . $group_id ."_" : "";
    }

    public function findKeysByPrefix($prefix)
    {
        return $this->redis->keys($prefix . "*");
    }
}