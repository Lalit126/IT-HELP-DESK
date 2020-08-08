<?php

namespace Helpdesk\Model;

class HelpdeskFollowupDTO {
    protected $FOLLOWUP_ID;
    protected $TICKET_ID;
    protected $STATUS_ID;
    protected $STATUS;
    protected $FOLLOWUP_TEXT;
    protected $FOLLOWUP_BY;
    protected $FOLLOWUP_ON;
    
    public function exchangeArray(array $data)
    {
        $this->FOLLOWUP_ID = ((!empty($data["FOLLOWUP_ID"])) ? $data["FOLLOWUP_ID"] : null);
        $this->TICKET_ID = ((!empty($data["TICKET_ID"])) ? $data["TICKET_ID"] : null);
        $this->STATUS_ID = ((!empty($data["STATUS_ID"])) ? $data["STATUS_ID"] : null);
        $this->FOLLOWUP_TEXT = ((!empty($data["FOLLOWUP_TEXT"])) ? $data["FOLLOWUP_TEXT"] : null);
        $this->FOLLOWUP_BY = ((!empty($data["FOLLOWUP_BY"])) ? $data["FOLLOWUP_BY"] : null);
        $this->FOLLOWUP_ON = ((!empty($data["FOLLOWUP_ON"])) ? $data["FOLLOWUP_ON"] : null);
    }
    
    public function toArray() {
        return [
            "FOLLOWUP_ID" => $this->FOLLOWUP_ID,
            "TICKET_ID" => $this->TICKET_ID,
            "STATUS_ID" => $this->STATUS_ID,
            "FOLLOWUP_TEXT" => $this->FOLLOWUP_TEXT,
            "FOLLOWUP_BY" => $this->FOLLOWUP_BY,
            "FOLLOWUP_ON" => $this->FOLLOWUP_ON
        ];
    }
    
    public function getFollowupId() {
        return $this->FOLLOWUP_ID;
    }
    
    public function getTicketId() {
        return $this->TICKET_ID;
    }
    
    public function getStatusId() {
        return $this->STATUS_ID;
    }
    
    public function getStatus() {
        return $this->STATUS;
    }
    
    public function setStatus($status) {
        $this->STATUS = $status;
    }
    
    public function getFollowupText() {
        return $this->FOLLOWUP_TEXT;
    }
    
    public function getFollowupBy() {
        return $this->FOLLOWUP_By;
    }
    
    public function getFollowupOn() {
        return $this->FOLLOWUP_ON;
    }
}