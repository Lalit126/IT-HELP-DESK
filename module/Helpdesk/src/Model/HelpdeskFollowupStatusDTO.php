<?php

namespace Helpdesk\Model;

class HelpdeskFollowupStatusDTO {
    protected $STATUS_ID;
    protected $STATUS;
    
    public function getStatusId() {
        return $this->STATUS_ID;
    }
    
    public function getStatus() {
        return $this->STATUS;
    }
}