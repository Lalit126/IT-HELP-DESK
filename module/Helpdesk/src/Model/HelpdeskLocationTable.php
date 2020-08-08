<?php

namespace Helpdesk\Model;

use Laminas\Paginator\Adapter\DbSelect;
use Laminas\Db\Sql\Select;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Paginator\Paginator;
use RuntimeException;

class HelpdeskLocationTable {
    private $tableGateway;
    
    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll() {
        return $this->tableGateway->select();
    }
    
    public function getHelpdeskLocation($location) {
        $location = (int)$location;
        $rowset = $this->tableGateway->select(["LOCATION_ID" => $location]);
        $row = $rowset->current();
        if (!$row) {
            throw new RuntimeException("Could not find row with identifier $location");
        }
        
        return $row;
    }
    
    public function getLookupList() {
        $locations = array();
        foreach ($this->fetchAll() as $helpdesklocation) $locations[$helpdesklocation->getLocationId()] = $helpdesklocation->getLocation();
        
        return $locations;
    }
}