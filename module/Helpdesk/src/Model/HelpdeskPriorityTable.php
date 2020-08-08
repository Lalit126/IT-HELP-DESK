<?php

namespace Helpdesk\Model;

use Laminas\Paginator\Adapter\DbSelect;
use Laminas\Db\Sql\Select;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Paginator\Paginator;
use RuntimeException;

class HelpdeskPriorityTable {
    private $tableGateway;
    
    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll() {
        return $this->tableGateway->select();
    }
    
    public function getHelpdeskPriority($priority) {
        $priority = (int)$priority;
        $rowset = $this->tableGateway->select(["PRIORITY_ID" => $priority]);
        $row = $rowset->current();
        if (!$row) {
            throw new RuntimeException("Could not find row with identifier $priority");
        }
        
        return $row;
    }
    
    public function getLookupList() {
        $priorities = array();
        foreach ($this->fetchAll() as $helpdeskpriority) $priorities[$helpdeskpriority->getPriorityId()] = $helpdeskpriority->getPriority();
        
        return $priorities;
    }
}