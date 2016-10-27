<?php
namespace {
    defined('SERVICE') or die('service not defined.');
}

namespace Swoole\Thrift {

    use Thrift;
    use Thrift\Server\TNonblockingServer;
    use Helper\Fn;
    use ZK\ZK;
    use ZK\ServiceRegistry;

    class Server extends TNonblockingServer
    {
        protected $processor = null;
        //protected $serviceName = 'Book';

        function onStart()
        {
            echo SERVICE . " Service Server Started @ ", date('Y-m-d H:i:s'), "\n";
        }

        function notice($log)
        {
            echo $log . "\n";
        }

        public function onReceive($serv, $fd, $from_id, $data)
        {
            $processor_class = "\\" . SERVICE . "\\". SERVICE . "Processor";
            $handler_class = "\\" . SERVICE . "\\Handler";

            $handler = new $handler_class();
            $this->processor = new $processor_class($handler);

            $socket = new Socket();
            $socket->setHandle($fd);
            $socket->buffer = $data;
            $socket->server = $serv;
            $protocol = new Thrift\Protocol\TBinaryProtocol($socket, false, false);

            try {
                //$protocol->fname = $this->serviceName;
                $protocol->fname = SERVICE;
                $this->processor->process($protocol, $protocol);
            } catch (\Exception $e) {
                $this->notice('CODE:' . $e->getCode() . ' MESSAGE:' . $e->getMessage() . "\n" . $e->getTraceAsString());
            }
        }

        public function onClose($serv, $fd, $from_id)
        {
            //
        }

        function serve()
        {
            $host = Fn::C('service.host');
            $port = Fn::C('service.port');

            $serv = new \swoole_server($host, $port);
            $serv->on('workerStart', [$this, 'onStart']);
            $serv->on('receive', [$this, 'onReceive']);
            $serv->on('close', [$this, 'onClose']);
            $serv->set(array(
                'worker_num'            => 1,
                'dispatch_mode'         => 1, //1: 轮循, 3: 争抢
                'open_length_check'     => true, //打开包长检测
                'package_max_length'    => 8192000, //最大的请求包长度,8M
                'package_length_type'   => 'N', //长度的类型，参见PHP的pack函数
                'package_length_offset' => 0,   //第N个字节是包长度的值
                'package_body_offset'   => 4,   //从第几个字节计算长度
            ));

            $serv->start();
        }
    }
}
