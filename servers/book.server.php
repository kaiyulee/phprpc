#!/usr/bin/env php
<?php

error_reporting(E_ALL);

require_once realpath(dirname(__FILE__) . '/../') . '/vendor/autoload.php';

// 每个服务定义自己的服务名称
define('SERVICE', 'Book');

use Thrift\ClassLoader\ThriftClassLoader;
use Thrift\Server\TServerSocket;
use Thrift\Exception\TException;
use Helper\Fn;
use Container\Container;
use ZK\ZK;
use ZK\Service;
use ZK\ServiceRegistry;

$loader = new ThriftClassLoader();
$loader->registerNamespace(SERVICE, GEN_DIR);
$loader->registerDefinition(SERVICE, GEN_DIR);
$loader->register();

if (php_sapi_name() == 'cli') {
    ini_set("display_errors", "stderr");
}

header('Content-Type', 'application/x-thrift');
if (php_sapi_name() == 'cli') {
    echo "\r\n";
}

try {

    // zookeeper 服务器配置
    $zk_host = Fn::C('zookeeper.host');
    $zk_port = Fn::C('zookeeper.port');

    // 服务自身对应的 ip:port
    $service_host = Fn::C('service.host');
    $service_port = Fn::C('service.port');

    $zk = new ZK($zk_host . ':' . $zk_port);
    Container::set('zk', $zk);

    /**
     * 启动时，自注册服务
     */

    // 准备服务信息
    $node_path = Fn::C('service.zk_node');
    $node_value = json_encode(['host'=>$service_host, 'port'=>$service_port]);
    $service = new Service($node_path, $node_value);

    // 注册到 zk
    ServiceRegistry::withSharedServer('zk');
    // 如果需要指定新的 zookeeper server， 使用 setServer 方法
    ServiceRegistry::register($node_path, $service);

    $handler_class = SERVICE . '\\' . 'Handler';
    $processor_class = SERVICE . '\\' . SERVICE . 'Processor';
    $handler = new $handler_class();
    $processor = new $processor_class($handler);

    $socket_transport = new TServerSocket($service_host, $service_port);
    $out_factory = $in_factory = new Thrift\Factory\TFramedTransportFactory();
    $out_protocol = $in_protocol = new Thrift\Factory\TBinaryProtocolFactory();
    $server = new Swoole\Thrift\Server($processor, $socket_transport, $in_factory, $out_factory, $in_protocol, $out_protocol);
    $server->serve();
} catch (TException $tx) {
    print 'TException: '.$tx->getMessage()."\n";
}
