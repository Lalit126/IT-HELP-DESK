<?php

namespace Helpdesk\Model;

class HelpdeskPriorityDTO {
    protected $PRIORITY_ID;
    protected $PRIORITY;
    
    public function getPriorityId() {
        return $this->PRIORITY_ID;
    }
    
    public function getPriority() {
        return $this->PRIORITY;
    }
}