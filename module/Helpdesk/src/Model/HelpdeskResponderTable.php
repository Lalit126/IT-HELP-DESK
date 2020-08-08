<?php

namespace Helpdesk\Model;

use Laminas\Paginator\Adapter\DbSelect;
use Laminas\Db\Sql\Select;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Paginator\Paginator;
use RuntimeException;

class HelpdeskResponderTable {
    private $tableGateway;
    
    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll() {
        return $this->tableGateway->select();
    }
    
    public function getHelpdeskResponder($ticket, $responder) {
        $ticket = (int)$ticket;
        $responder = (int)$responder;
        $rowset = $this->tableGateway->select(["TICKET_ID" => $ticket,
                                               "RESPONDER_ID" => $responder]);
        $row = $rowset->current();
        if (!$row) {
            throw new RuntimeException("Could not find row with identifier $ticket & $responder");
        }
        
        return $row->current();
    }
    
    public function getHelpdeskResponders($ticket) {
        if (!isset($ticket) || !is_numeric($ticket)) $ticket = -1;
        
        $countQuery = new Select();
        $countQuery->from("HELPDESK_RESPONDERS")
                   ->where(["TICKET_ID" => $ticket]);
        
        $adapter = new DbSelect($countQuery, $this->tableGateway->getAdapter(), $this->tableGateway->getResultSetPrototype());
        
        # Use pagination in order to get the total count of records
        $paginator = new Paginator($adapter);
        
        return $paginator;
        /*
        $ticket = (int)$ticket;
        $rowset = $this->tableGateway->select(["TICKET_ID" => $ticket]);
        
        //$row = $rowset->current();
        //if (!$row) {
        //    throw new RuntimeException("Could not find row with identifier $ticket");
        //}
        
        return $rowset;*/
    }
    
    public function getNumberHelpdeskResponders($ticket) {
        if (!isset($ticket) || !is_numeric($ticket)) $ticket = -1;
        
        # Use pagination in order to get the total count of records
        $paginator = $this->getHelpdeskResponders($ticket);
        
        return $paginator->getTotalItemCount();
    }
    
    public function saveHelpdeskResponder(HelpdeskResponderModel $helpdeskresponder) {
        $data = [
            
        ];
        
        $ticket = (int)$data->TICKET_ID;
        $responder = (int)$data->RESPONDER_ID;
        
        if (($ticket === 0) && ($reponder === 0)) {
            $this->tableGateway->insert($data);
            return;
        }
        
        try {
            $this->getHelpdeskResponder($ticket, $responder);
        } catch (RuntimeException $e) {
            throw new RuntimeException("Cannot update helpdesk responder with identifier $ticket & $responder; does not exist");
        }
        
        $this->tableGateway->update($data, ["TICKET_ID" => $ticket,
                                            "RESPONDER_ID" => $responder
        ]);
    }
}