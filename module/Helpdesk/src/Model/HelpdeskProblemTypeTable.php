<?php

namespace Helpdesk\Model;

use Laminas\Paginator\Adapter\DbSelect;
use Laminas\Db\Sql\Select;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Paginator\Paginator;
use RuntimeException;

class HelpdeskProblemTypeTable {
    private $tableGateway;
    
    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll() {
        return $this->tableGateway->select();
    }
    
    public function getHelpdeskProblemType($problemtype) {
        $problemtype = (int)$problemtype;
        $rowset = $this->tableGateway->select(["PROBLEM_TYPE_ID" => $problemtype]);
        $row = $rowset->current();
        if (!$row) {
            throw new RuntimeException("Could not find row with identifier $problemtype");
        }
        
        return $row;
    }
    
    public function getLookupList() {
        $problemtypes = array();
        foreach ($this->fetchAll() as $helpdeskproblemtype) $problemtypes[$helpdeskproblemtype->getProblemTypeId()] = $helpdeskproblemtype->getProblemType();
        
        return $problemtypes;
    }
}