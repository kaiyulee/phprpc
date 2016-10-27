<?php
namespace Thrift\Factory;
use Thrift\Transport\TFramedTransport;
use Thrift\Transport\TTransport;
class TFramedTransportFactory extends TTransportFactory{
    /**
     * @static
     * @param TTransport $transport
     * @return TTransport
     */
    public static function getTransport(TTransport $transport) {
        return new TFramedTransport($transport);
    }
}
