<?php

namespace Helpdesk\Model;

class HelpdeskResponderDTO {
    protected $TICKET_ID;
    protected $RESPONDER_ID;
    
    public function getTicketId() {
        return $this->TICKET_ID;
    }
    
    public function getResponderId() {
        return $this->RESPONDER_ID;
    }
}