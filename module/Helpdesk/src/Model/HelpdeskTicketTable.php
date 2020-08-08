<?php

namespace Helpdesk\Model;

use DateTime;
use Laminas\Paginator\Adapter\DbSelect;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\Where;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Paginator\Paginator;
use Laminas\Validator\Date;
use Helpdesk\Model\HelpdeskResponderTable;
use Helpdesk\Model\HelpdeskFollowupTable;
use Helpdesk\Model\HelpdeskPriorityTable;
use Helpdesk\Model\HelpdeskLocationTable;
use Helpdesk\Model\HelpdeskProblemTypeTable;
use Helpdesk\Model\HelpdeskStatusTable;
use RuntimeException;

class HelpdeskTicketTable {
    private $ticketTableGateway;
    private $responderTable;
    private $followupsTable;
    private $priorityTable;
    private $locationTable;
    private $problemTypeTable;
    private $statusTable;
    
    public function __construct(TableGatewayInterface $ticketTableGateway,
                                HelpdeskResponderTable $responderTable,
                                HelpdeskFollowupTable $followupsTable,
                                HelpdeskPriorityTable $priorityTable,
                                HelpdeskLocationTable $locationTable,
                                HelpdeskProblemTypeTable $problemTypeTable,
                                HelpdeskStatusTable $statusTable) {
        $this->ticketTableGateway = $ticketTableGateway;
        $this->responderTable = $responderTable;
        $this->followupsTable = $followupsTable;
        $this->priorityTable = $priorityTable;
        $this->locationTable = $locationTable;
        $this->problemTypeTable = $problemTypeTable;
        $this->statusTable = $statusTable;
    }
    
    public function fetchAll() {
        //return $this->ticketTableGateway->select();
        
        /* Note: Joining would be benefitial if relationship was one-to-one in order to
         *       producte the proper array structure (one record each with embedded array
         *       of responders). This relationship is a one-to-many so perform an extra
         *       query to get the responders.
         */
        //$resultset = $this->ticketTableGateway->select(function(Select $sql) {
            /* Left join on the HELPDESK_RESPONDERS table including a columns from the join */
        //    $sql->join(['hr' => 'HELPDESK_RESPONDERS'], 'HELPDESK_TICKETS.TICKET_ID = hr.TICKET_ID', ['RESPONDER_ID'], $sql::JOIN_LEFT);
        //});
        
        $resultset = $this->ticketTableGateway->select();
        
        $resultset->buffer();
        
        foreach ($resultset as $helpdeskticket) {
            # Obtain All Responders For This Helpdesk Ticket
            $responderpaginator = $this->responderTable->getHelpdeskResponders($helpdeskticket->getTicketId());
            $responders = array();

            for ($i = 1; $i <= $responderpaginator->count(); $i++) {
                $responderpaginator->setCurrentPageNumber($i);
                foreach ($responderpaginator as $responder) $responders[] = $responder->getResponderId();
            }
            
            # Obtain All Followups For This Helpdesk Ticket
            $followuppaginator = $this->followupsTable->getHelpdeskFollowups($helpdeskticket->getTicketId());
            $followups = array();
            
            for ($i = 1; $i <= $followuppaginator->count(); $i++) {
                $followuppaginator->setCurrentPageNumber($i);
                foreach ($followuppaginator as $followup) $followups[] = $followup;
            }
            
            $helpdeskticket->setResponders($responders);
            $helpdeskticket->setFollowups($followups);
            $helpdeskticket->setPriority($this->priorityTable->getHelpdeskPriority($helpdeskticket->getPriorityId()));
            $helpdeskticket->setLocation($this->locationTable->getHelpdeskLocation($helpdeskticket->getLocationId()));
            $helpdeskticket->setProblemType($this->problemTypeTable->getHelpdeskProblemType($helpdeskticket->getProblemTypeId()));
            $helpdeskticket->setStatus($this->statusTable->getHelpdeskStatus($helpdeskticket->getStatusId()));
            /* Verify that dates are valid coming from the database and convert format for readability */
            if ($helpdeskticket->getEnteredOn() && (new Date(["format" => "Y-m-d H:i:s"]))->isValid($helpdeskticket->getEnteredOn())) {
                $helpdeskticket->setEnteredOn_Date(DateTime::createFromFormat("Y-m-d H:i:s", $helpdeskticket->getEnteredOn())->format("m/d/Y"));
                $helpdeskticket->setEnteredOn_DateTime(DateTime::createFromFormat("Y-m-d H:i:s", $helpdeskticket->getEnteredOn())->format("m/d/Y H:i:s"));
            }
            if ($helpdeskticket->getUpdatedOn() && (new Date(["format" => "Y-m-d H:i:s"]))->isValid($helpdeskticket->getUpdatedOn())) {
                $helpdeskticket->setUpdatedOn_Date(DateTime::createFromFormat("Y-m-d H:i:s", $helpdeskticket->getUpdatedOn())->format("m/d/Y"));
                $helpdeskticket->setUpdatedOn_DateTime(DateTime::createFromFormat("Y-m-d H:i:s", $helpdeskticket->getUpdatedOn())->format("m/d/Y H:i:s"));
            }
        }
        
        $resultset->rewind();
        
        return $resultset;
    }
    
    public function fetchUnassigned() {
        $countQuery = new Select();
        $countQuery->from("HELPDESK_TICKETS")
                   ->where(["STATUS" => "Pending"])
                   ->where(function(Where $where) {
                       $where->notIn("HELPDESK_TICKETS.TICKET_ID", (new Select())->from("HELPDESK_RESPONDERS")
                             ->columns(["TICKET_ID"])
                             ->where("HELPDESK_RESPONDERS.TICKET_ID = HELPDESK_TICKETS.TICKET_ID"));
                   });
        
        # Create a DbSelect object that paginates the rows from the database
        $adapter = new DbSelect($countQuery, $this->ticketTableGateway->getAdapter(), $this->ticketTableGateway->getResultSetPrototype());
        
        
        $sql = new Sql($this->ticketTableGateway->getAdapter());
        //var_dump($sql->buildSqlString($countQuery, $this->ticketTableGateway->getAdapter()));
        
        
        # Create a pagination data collection
        $paginator = new Paginator($adapter);
        //var_dump($paginator->getTotalItemCount());
        //var_dump("Unassigned");
        
        return $paginator;
    }
    
    public function fetchFollowups() {        
        $countQuery = new Select();
        $countQuery->from("HELPDESK_TICKETS")
                   ->where(function(Where $where) {
                       $where->in("HELPDESK_TICKETS.TICKET_ID", (new Select())->from("HELPDESK_FOLLOWUPS")
                                                                              ->columns(["TICKET_ID"])
                                                                              ->where("HELPDESK_FOLLOWUPS.TICKET_ID = HELPDESK_TICKETS.TICKET_ID")
                                                                              /*->where(function(Where $innerwhere) {
                                                                                  $innerwhere
                                                                                  ["HELPDESK_FOLLOWUPS.TICKET_ID" => "HELPDESK_TICKETS.TICKET_ID"]
                                                                              })*/);
                   });
                                                                          
        
        # Create a DbSelect object that paginates the rows from the database
        $adapter = new DbSelect($countQuery, $this->ticketTableGateway->getAdapter(), $this->ticketTableGateway->getResultSetPrototype());
        
        
        //$sql = new Sql($this->ticketTableGateway->getAdapter());
        ////var_dump($sql->buildSqlString($countQuery, $this->ticketTableGateway->getAdapter()));
        
        
        # Create a pagination data collection
        $paginator = new Paginator($adapter);
        //var_dump($paginator->getTotalItemCount());
        //var_dump("Followup");
        //ini_set("xdebug.var_display_max_children", -1);
        //ini_set("xdebug.var_display_max_data", -1);
        //ini_set("xdebug.var_display_max_depth", -1);
        ////var_dump($paginator);
        
        //foreach ($paginator as $helpdeskticket) //var_dump($helpdeskticket);
        
        for ($i = 1; $i <= $paginator->count(); $i++) {
            $paginator->setCurrentPageNumber($i);
            foreach ($paginator as $helpdeskticket) {
                # Obtain All Responders For This Helpdesk Ticket
                $responderpaginator = $this->responderTable->getHelpdeskResponders($helpdeskticket->getTicketId());
                $responders = array();
                
                for ($j = 1; $j <= $responderpaginator->count(); $j++) {
                    $responderpaginator->setCurrentPageNumber($j);
                    foreach ($responderpaginator as $responder) $responders[] = $responder->getResponderId();
                }
                
                # Obtain All Followups For This Helpdesk Ticket
                $followuppaginator = $this->followupsTable->getHelpdeskFollowups($helpdeskticket->getTicketId());
                $followups = array();
                $latestfollowup = null;
                
                for ($j = 1; $j <= $followuppaginator->count(); $j++) {
                    $followuppaginator->setCurrentPageNumber($j);
                    foreach ($followuppaginator as $followup) {
                        $followups[] = $followup;
                        
                        if (!$latestfollowup) $latestfollowup = $followup;
                    }
                }
                
                $helpdeskticket->setResponders($responders);
                $helpdeskticket->setFollowups($followups);
                $helpdeskticket->setLatestFollowup($latestfollowup);
                $helpdeskticket->setPriority($this->priorityTable->getHelpdeskPriority($helpdeskticket->getPriorityId()));
                $helpdeskticket->setLocation($this->locationTable->getHelpdeskLocation($helpdeskticket->getLocationId()));
                $helpdeskticket->setProblemType($this->problemTypeTable->getHelpdeskProblemType($helpdeskticket->getProblemTypeId()));
                $helpdeskticket->setStatus($this->statusTable->getHelpdeskStatus($helpdeskticket->getStatusId()));
            }
        }
        
        return $paginator;
        
        /*
        $resultset = $this->ticketTableGateway->select();
        
        $resultset->buffer();
        
        foreach ($resultset as $helpdeskticket) {
            $responderset = $this->responderTable->getHelpdeskResponders($helpdeskticket->getTicketId());
            $responders = array();
            foreach ($responderset as $responder) $responders[] = $responder->getResponderId();
            
            $followupset = $this->followupsTable->getHelpdeskFollowups($helpdeskticket->getTicketId());
            $followups = array();
            foreach ($followupset as $followup) $followups[] = $followup;
            
            $helpdeskticket->setResponders($responders);
            $helpdeskticket->setFollowups($followups);
        }
        
        $resultset->rewind();
        
        return $resultset;
        */
    }
    
    public function fetchPending() {
        $countQuery = new Select();
        $countQuery->from("HELPDESK_TICKETS")
                   ->where(["STATUS" => "Pending"])
                   ->where(function(Where $where) {
                       $where->in("HELPDESK_TICKETS.TICKET_ID", (new Select())->from("HELPDESK_RESPONDERS")
                             ->columns(["TICKET_ID"])
                             ->where("HELPDESK_RESPONDERS.TICKET_ID = HELPDESK_TICKETS.TICKET_ID"));
                   });
        
        # Create a DbSelect object that paginates the rows from the database
        $adapter = new DbSelect($countQuery, $this->ticketTableGateway->getAdapter(), $this->ticketTableGateway->getResultSetPrototype());
        
        
        $sql = new Sql($this->ticketTableGateway->getAdapter());
        //var_dump($sql->buildSqlString($countQuery, $this->ticketTableGateway->getAdapter()));
        
        
        # Create a pagination data collection
        $paginator = new Paginator($adapter);
        //var_dump($paginator->getTotalItemCount());
        //var_dump("Pending");
        
        return $paginator;
    }
    
    public function fetchOrdered() {
        $countQuery = new Select();
        $countQuery->from("HELPDESK_TICKETS")
        ->where(["STATUS" => "Ordered"])
        ->where(function(Where $where) {
            $where->in("HELPDESK_TICKETS.TICKET_ID", (new Select())->from("HELPDESK_RESPONDERS")
                  ->columns(["TICKET_ID"])
                  ->where("HELPDESK_RESPONDERS.TICKET_ID = HELPDESK_TICKETS.TICKET_ID"));
        });
        
        # Create a DbSelect object that paginates the rows from the database
        $adapter = new DbSelect($countQuery, $this    
    ->ticketTableGateway->getAdapter(), $this->ticketTableGateway->getResultSetPrototype());
        
        
        $sql = new Sql($this->ticketTableGateway->getAdapter());
        //var_dump($sql->buildSqlString($countQuery, $this->ticketTableGateway->getAdapter()));
        
        
        # Create a pagination data collection
        $paginator = new Paginator($adapter);
        //var_dump($paginator->getTotalItemCount());
        //var_dump("Ordered");
        
        return $paginator;
    }
    
    public function getHelpdeskTicket($ticket) {
        $ticket = (int)$ticket;
        $rowset = $this->ticketTableGateway->select(["TICKET_ID" => $ticket]);
        $helpdeskticket = $rowset->current();
        
        if (!$helpdeskticket) {
            return null;
        }
        
        # Obtain All Responders For This Helpdesk Ticket
        $responderpaginator = $this->responderTable->getHelpdeskResponders($helpdeskticket->getTicketId());
        $responders = array();
        
        for ($j = 1; $j <= $responderpaginator->count(); $j++) {
            $responderpaginator->setCurrentPageNumber($j);
            foreach ($responderpaginator as $responder) $responders[] = $responder->getResponderId();
        }
        
        # Obtain All Followups For This Helpdesk Ticket
        $followuppaginator = $this->followupsTable->getHelpdeskFollowups($helpdeskticket->getTicketId());
        $followups = array();
        $latestfollowup = null;
        
        for ($j = 1; $j <= $followuppaginator->count(); $j++) {
            $followuppaginator->setCurrentPageNumber($j);
            foreach ($followuppaginator as $followup) {
                $followups[] = $followup;
                
                if (!$latestfollowup) $latestfollowup = $followup;
            }
        }
        
        //var_dump($followups);
        
        $helpdeskticket->setResponders($responders);
        $helpdeskticket->setFollowups($followups);
        $helpdeskticket->setLatestFollowup($latestfollowup);
        $helpdeskticket->setPriority($this->priorityTable->getHelpdeskPriority($helpdeskticket->getPriorityId()));
        $helpdeskticket->setLocation($this->locationTable->getHelpdeskLocation($helpdeskticket->getLocationId()));
        $helpdeskticket->setProblemType($this->problemTypeTable->getHelpdeskProblemType($helpdeskticket->getProblemTypeId()));
        $helpdeskticket->setStatus($this->statusTable->getHelpdeskStatus($helpdeskticket->getStatusId()));
        /* Verify that dates are valid coming from the database and convert format for readability */
        if ($helpdeskticket->getEnteredOn() && (new Date(["format" => "Y-m-d H:i:s"]))->isValid($helpdeskticket->getEnteredOn())) {
            $helpdeskticket->setEnteredOn_Date(DateTime::createFromFormat("Y-m-d H:i:s", $helpdeskticket->getEnteredOn())->format("m/d/Y"));
            $helpdeskticket->setEnteredOn_DateTime(DateTime::createFromFormat("Y-m-d H:i:s", $helpdeskticket->getEnteredOn())->format("m/d/Y H:i:s"));
        }
        if ($helpdeskticket->getUpdatedOn() && (new Date(["format" => "Y-m-d H:i:s"]))->isValid($helpdeskticket->getUpdatedOn())) {
            $helpdeskticket->setUpdatedOn_Date(DateTime::createFromFormat("Y-m-d H:i:s", $helpdeskticket->getUpdatedOn())->format("m/d/Y"));
            $helpdeskticket->setUpdatedOn_DateTime(DateTime::createFromFormat("Y-m-d H:i:s", $helpdeskticket->getUpdatedOn())->format("m/d/Y H:i:s"));
        }
        
        return $helpdeskticket;
    }
    
    public function createHelpdeskTicket(HelpdeskTicketDTO $helpdeskticket) {
        $data = $helpdeskticket->toArray();
        //var_dump($data);
        
        $ticket = (int)$data->TICKET_ID;
        
        if (!$data->TICKET_ID) {
            //var_dump($this->ticketTableGateway->insert($data));
            return;
        }
        
        
    }
    
    public function updateHelpdeskTicket(HelpdeskTicketDTO $helpdeskticket) {
        $data = $helpdeskticket->toArray();
        //var_dump($data);
        
        /* TODO: CHECK BETTER WAY FOR EXISTS */
        
        try {
            $this->getHelpdeskTicket($ticket);
        } catch (RuntimeException $e) {
            throw new RuntimeException("Cannot update ticket with identifier $ticket; does not exist");
        }
        
        $this->ticketTableGateway->update($data, ["TICKET_ID" => $ticket]);
    }
}