<?php

namespace Helpdesk\Model;

use Laminas\Paginator\Adapter\DbSelect;
use Laminas\Db\Sql\Select;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Paginator\Paginator;
use RuntimeException;
use Helpdesk\Model\HelpdeskFollowupStatusTable;

class HelpdeskFollowupTable {
    private $followupTableGateway;
    private $statusTable;
    
    public function __construct(TableGatewayInterface $followupTableGateway,
                                HelpdeskFollowupStatusTable $statusTable) {
        $this->followupTableGateway = $followupTableGateway;
        $this->statusTable = $statusTable;
    }
    
    public function fetchAll() {
        return $this->followupTableGateway->select();
    }
    
    public function getHelpdeskFollowup($followup) {
        $followup = (int)$followup;
        $rowset = $this->followupTableGateway->select(["FOLLOWUP_ID" => $followup]);
        $followup = $rowset->current();
        if (!$followup) {
            return null;
        }
        
        $followup->setStatus($this->statusTable->getHelpdeskFollowupStatus($followup->getStatusId()));
        
        return $followup;
    }
    
    public function getHelpdeskFollowups($ticket) {
        if (!isset($ticket) || !is_numeric($ticket)) $ticket = -1;
        
        $countQuery = new Select();
        $countQuery->from("HELPDESK_FOLLOWUPS")
                   ->where(["TICKET_ID" => $ticket]);
        
        $adapter = new DbSelect($countQuery, $this->followupTableGateway->getAdapter(), $this->followupTableGateway->getResultSetPrototype());
        
        # Use pagination in order to get the total count of records
        $paginator = new Paginator($adapter);
        
        /* TODO: IS THERE A WAY TO MODIFY PAGINATOR TO EMBED EACH RECORDS FOLLOWUP STATUS
         *       OBJECT TO KEEP THE EXECTED OBJECT TREE CONSISTENT?? FOLLOWUP STATUS
         *       OBJECT IS CLEARED
         */
        for ($i = 1; $i <= $paginator->count(); $i++) {
            $paginator->setCurrentPageNumber($i);
            
            foreach ($paginator as $followup) {
                $followup->setStatus($this->statusTable->getHelpdeskFollowupStatus($followup->getStatusId()));
            }
        }
        
        return $paginator;
    }
    
    public function getNumberHelpdeskFollowups($ticket) {
        if (!isset($ticket) || !is_numeric($ticket)) $ticket = -1;
        
        # Use pagination in order to get the total count of records
        $paginator = $this->getHelpdeskFollowups($ticket); 
        
        return $paginator->getTotalItemCount();
    }
    
    public function saveHelpdeskFollowup(HelpdeskFollowupModel $helpdeskfollowup) {
        $data = [
            
        ];
        
        $followup = (int)$data->FOLLOWUP_ID;
        
        if (($followup === 0)) {
            $this->followupTableGateway->insert($data);
            return;
        }
        
        try {
            $this->getHelpdeskFollowup($followup);
        } catch (RuntimeException $e) {
            throw new RuntimeException("Cannot update helpdesk followup with identifier $followup; does not exist");
        }
        
        $this->followupTableGateway->update($data, ["FOLLOWUP_ID" => $followup ]);
    }
}