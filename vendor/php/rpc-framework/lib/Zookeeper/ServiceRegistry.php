<?php

namespace ZK;

use ZK\Service;
use ZK\ZK;

/**
 * Service registry
 */
class ServiceRegistry
{
    
    private static $services = [];
    protected static $zk;

    public function __construct(ZK $zk)
    {
        self::$zk = $zk;
    }

    public static function register($name, Service $service)
    {
        self::$services[$name] = $service;

        $path = $service->getNodePath();
        $val = $service->getNodeValue();

        return self::$zk->set($path, $val); // mixed | null
    }

    public static function deregister($name)
    {
        if (isset(self::$services[$name])) {

            if (!(self::$services[$name] instanceof Service)) {
                throw new \Exception("not a service object", 1);
            }

            $path = self::$services[$name]->getNodePath();

            $empty = empty(self::$zk->getChildren($path));
            
            if (!$empty) {
                throw new \Exception("not a empty node", 1);
            }

            unset(self::$services[$name]);

            return self::$zk->deleteNode($path); // true | null
        }

        return true;
    }
}