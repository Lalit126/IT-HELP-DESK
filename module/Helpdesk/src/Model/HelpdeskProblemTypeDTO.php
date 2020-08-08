<?php

namespace Helpdesk\Model;

class HelpdeskProblemTypeDTO {
    protected $PROBLEM_TYPE_ID;
    protected $PROBLEM_TYPE;
    
    public function getProblemTypeId() {
        return $this->PROBLEM_TYPE_ID;
    }
    
    public function getProblemType() {
        return $this->PROBLEM_TYPE;
    }
}