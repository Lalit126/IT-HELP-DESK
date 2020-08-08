<?php

namespace Helpdesk\Model;

class HelpdeskStatusDTO {
    protected $STATUS_ID;
    protected $STATUS;
    
    public function getStatusId() {
        return $this->STATUS_ID;
    }
    
    public function getStatus() {
        return $this->STATUS;
    }
}