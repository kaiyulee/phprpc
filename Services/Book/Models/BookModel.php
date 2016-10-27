<?php

namespace Book\Models;

use DB\Pdo as Pdo;
use DB\Redis as Redis;
use Helper\Fn;

class BookModel
{
    protected $_instance;

    /**
     * @return string
     */
    public function test()
    {
        $cfg = Fn::C('db3');
        $db = Pdo::setDb($cfg);
        var_dump($db);

        return 'test';
    }

    public function test2()
    {
        $cfg = Fn::C('redis');

        $redis = new Redis($cfg);

        var_dump($redis);

        var_dump($redis->ping());
    }
}
