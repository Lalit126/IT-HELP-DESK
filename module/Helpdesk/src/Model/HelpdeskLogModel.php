<?php

namespace Helpdesk\Model;

class HelpdeskLogModel {
    public $LOG_ID;
    public $TICKET_ID;
    public $TYPE;
    public $ENTRY;
    public $ATTACHMENT_BLOB;
    public $ATTACHMENT_TYPE;
    public $ENTERED_BY;
    public $ENTERED_ON;
    public $UPDATED_BY;
    public $UPDATED_ON;
    
    public function exchangeArray(array $data)
    {
        $this->LOG_ID = ((!empty($data["LOG_ID"])) ? $data["LOG_ID"] : null);
        $this->TICKET_ID = ((!empty($data["TICKET_ID"])) ? $data["TICKET_ID"] : null);
        $this->TYPE = ((!empty($data["TYPE"])) ? $data["TYPE"] : null);
        $this->ENTRY = ((!empty($data["ENTRY"])) ? $data["ENTRY"] : null);
        $this->ATTACHMENT_BLOB = ((!empty($data["ATTACHMENT_BLOB"])) ? $data["ATTACHMENT_BLOB"] : null);
        $this->ATTACHMENT_TYPE = ((!empty($data["ATTACHMENT_TYPE"])) ? $data["ATTACHMENT_TYPE"] : null);
        $this->ENTERED_BY = ((!empty($data["ENTERED_BY"])) ? $data["ENTERED_BY"] : null);
        $this->ENTERED_ON = ((!empty($data["ENTERED_ON"])) ? $data["ENTERED_ON"] : null);
        $this->UPDATED_BY = ((!empty($data["UPDATED_BY"])) ? $data["UPDATED_BY"] : null);
        $this->UPDATED_ON = ((!empty($data["UPDATED_ON"])) ? $data["UPDATED_ON"] : null);
    }
}