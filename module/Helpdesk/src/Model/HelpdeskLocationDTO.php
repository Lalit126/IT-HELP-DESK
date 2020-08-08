<?php

namespace Helpdesk\Model;

class HelpdeskLocationDTO {
    protected $LOCATION_ID;
    protected $LOCATION;
    
    public function getLocationId() {
        return $this->LOCATION_ID;
    }
    
    public function getLocation() {
        return $this->LOCATION;
    }
}