<?php

namespace ZK;

/**
* service
*/
class Service
{
    
    private $node_path = null;
    private $node_value = null;

    function __construct($node_path, $node_value)
    {
        $this->node_path = $node_path;
        $this->node_value = $node_value;
    }

    public function getNodePath()
    {
        return $this->node_path;
    }

    public function getNodeValue()
    {
        return $this->node_value;
    }
}