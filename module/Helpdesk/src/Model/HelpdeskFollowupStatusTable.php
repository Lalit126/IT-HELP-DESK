<?php

namespace Helpdesk\Model;

use Laminas\Paginator\Adapter\DbSelect;
use Laminas\Db\Sql\Select;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Paginator\Paginator;
use RuntimeException;

class HelpdeskFollowupStatusTable {
    private $tableGateway;
    
    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll() {
        return $this->tableGateway->select();
    }
    
    public function getHelpdeskFollowupStatus($status) {
        $status = (int)$status;
        $rowset = $this->tableGateway->select(["STATUS_ID" => $status]);
        $row = $rowset->current();
        if (!$row) {
            throw new RuntimeException("Could not find row with identifier $status");
        }
        
        return $row;
    }
    
    public function getDefaultLookupId() {
        return array_flip($this->getLookupList())["Open"];
    }
    
    public function getLookupList() {
        $statuses = array();
        foreach ($this->fetchAll() as $helpdeskstatus) $statuses[$helpdeskstatus->getStatusId()] = $helpdeskstatus->getStatus();
        
        return $statuses;
    }
}