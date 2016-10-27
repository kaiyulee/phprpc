<?php

namespace ZK;

use ZK\ZK;

/**
* service discovery
*/
class ServiceDiscovery
{
    public static $zk;

    public function __construct(ZK $zk)
    {
        self::$zk = $zk;
    }

    public function discover($service_node)
    {
        $val = self::$zk->get($service_node);

        if (empty($val)) {
            return null;
        }

        return $val;
    }
}
