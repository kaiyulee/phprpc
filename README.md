# The PHP RPC Framework

### Zookeeper 实现服务注册与发现

**注册**：

file: `/servers/book.server.php`
```php
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
    $registry = new ServiceRegistry($zk);

    /**
     * 启动时，自注册服务
     */

    // 准备服务信息
    $node_path = Fn::C('service.zk_node');
    $node_value = json_encode(['host'=>$service_host, 'port'=>$service_port]);
    $service = new Service($node_path, $node_value);

    // 注册到 zk
    $registry->register($node_path, $service);
	
	...
	
} catch (TException $tx) {
    print 'TException: '.$tx->getMessage()."\n";
}
```
**发现**

file: `/clients/book.client.php`

```php
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
    
  	...

} catch (TException $tx) {
    print 'TException: '.$tx->getMessage()."\n";
}

```

#### To be done ...
