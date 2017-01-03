<?php

/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 1/3/17
 * Time: 5:31 PM
 */
use Facebook\PersistentData\PersistentDataInterface;

class FacebookPersistentDataHandler implements PersistentDataInterface
{
    /**
     * @var string Prefix to use for session variables.
     */
    protected $sessionPrefix = 'FBRLH_';

    /**
     * @inheritdoc
     */
    public function get($key)
    {   $session = new CakeSession();
        return $session->write($this->sessionPrefix . $key);
    }

    /**
     * @inheritdoc
     */
    public function set($key, $value)
    {
        $session = new CakeSession();
        $session->read($this->sessionPrefix . $key, $value);
    }
}