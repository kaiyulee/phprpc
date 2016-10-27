<?php
error_reporting(E_ALL);

require realpath(dirname(__FILE__) . '/../') .'/vendor/autoload.php';

use Thrift\ClassLoader\ThriftClassLoader;
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TSocket;
use Thrift\Transport\TFramedTransport;
use Thrift\Exception\TException;
use ZK\ZK;
use ZK\ServiceDiscovery;

$ROOT = realpath(dirname(__FILE__).'/../');
$LIB_PATH = $ROOT . '/lib/';
$GEN_DIR = $ROOT .'/Services/';

$loader = new ThriftClassLoader();
$loader->registerNamespace('Thrift', $LIB_PATH);
//$loader->registerNamespace('Swoole', $ROOT);
$loader->registerNamespace('Book', $GEN_DIR);
$loader->registerDefinition('Book', $GEN_DIR);
$loader->register();

try {
    // 发现服务, 各客户端自己实现
    $zk = new ZK('127.0.0.1:32772'); // zk 服务配置可根据客户端的具体环境配置
    $zk_service_node = '/service/book';

    $discovery = new ServiceDiscovery($zk);

    $service = $discovery->discover($zk_service_node);

    if (empty($service)) {
        die('no service available for this client!');
    }

    $service= json_decode($service, true);
    $service_host = $service['host'];
    $service_port = $service['port'];

    $socket = new TSocket($service_host, $service_port);
    $transport = new TFramedTransport($socket, 1024, 1024);
    $protocol = new TBinaryProtocol($transport);
    $client = new Book\BookClient($protocol);

    $transport->open();

    $info = $client->getBookInfo(6);
    var_dump($info);

    $transport->close();

} catch (TException $tx) {
    print 'TException: '.$tx->getMessage()."\n";
}


