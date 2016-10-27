<?php

namespace Container;

class Container
{
    protected static $instance;

    protected static $instances = [];

    public static function getInstance()
    {
        return static::$instance;
    }

    public static function bind($name, $zk)
    {
        static::$instances[$name] = $zk;
    }

    public function unbind()
    {

    }
}
