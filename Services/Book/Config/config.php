<?php
/**
 * database configuration
 *
 */
return [
    'service' => [
        'host' => '127.0.0.1',
        'port' => '8095',
        'zk_node' => '/service/book', // zookeeper node path,
    ],

    'db1' => [
        'host' => '127.0.0.1',
        'port' => '3306',
        'db' => 'sds',
        'username' => 'root',
        'password' => '123456',
    ],
    'db2' => [
        'host' => '192.168.1.7',
        'port' => '3306',
        'db' => 'sdssr',
        'username' => 'root',
        'password' => '',
    ],

    'redis' => [
        'host' => '192.168.1.12',
        'port' => '6379',
        'password' => 'abcde',
    ],

    'zookeeper' => [
        'host' => '127.0.0.1',
        'port' => '32772',
    ],
];
