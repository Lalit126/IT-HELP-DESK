<?php 

namespace Helpdesk\Form;

use Laminas\Form\Form;
use Laminas\Validator\LessThan;

class HelpdeskFollowupForm extends Form {
    public function __construct($ticket, $statuses, $name = null, $options=[]) {
        parent::__construct($name, $options);
        
        $this->add([
            "name" => "TICKET_ID",
            "type" => "Text",
            "class" => "form-control",
            "options" => [
                "label" => "Ticket",
                "value" => $ticket,
            ],
        ]);
        
        $this->add([
            "name" => "STATUS_ID",
            "type" => "Select",
            "class" => "form-control",
            "options" => [
                "label" => "Status",
                /* Ignore notInArray : The input was not found in the haystack */
                "disable_inarray_validator" => true,
                "value_options" => $statuses,
            ],
        ]);
        
        $this->add([
            "name" => "FOLLOWUP_BY",
            "type" => "Text",
            "class" => "form-control",
            "placeholder" => "Followup By",
            "options" => [
                "label" => "Followup By",
            ],
        ]);
        
        $this->add([
            "name" => "FOLLOWUP_ON",
            "type" => "Text",
            "class" => "form-control",
            "placeholder" => "Followup On",
            "options" => [
                "label" => "Followup On",
            ],
        ]);
        
        $this->add([
            "name" => "Submit",
            "type" => "Submit",
            "attributes" => [
                "value" => "Submit Helpdesk Followup"
            ],
            
        ]);
    }
    
    public function isValid() {
        $valid = parent::isValid();
        
        $extravalid = true;
        
        $data = $this->getData();
        
        /* Validate against maximum number of priorities */
        $max = count($this->get("TICKET_ID")->getOption("value_options"));
        $validator = new LessThan(["max" => "$max", "inclusive" => true]);
        $validator->setMessages([LessThan::NOT_LESS => "Value Not In List",
            LessThan::NOT_LESS_INCLUSIVE => "Value Not In List"]);
        
        $extravalid &= $validator->isValid($data["TICKET_ID"]);
        
        if ($validator->getMessages()) {
            $this->get("TICKET_ID")->setMessages($validator->getMessages());
            $this->messages["TICKET_ID"] = $validator->getMessages();
        }
        
        /* Validate against maximum number of statuses */
        $max = count($this->get("STATUS_ID")->getOption("value_options"));
        $validator = new LessThan(["max" => "$max", "inclusive" => true]);
        $validator->setMessages([LessThan::NOT_LESS => "Value Not In List",
            LessThan::NOT_LESS_INCLUSIVE => "Value Not In List"]);
        
        $extravalid &= $validator->isValid($data["STATUS_ID"]);
        
        if ($validator->getMessages()) {
            $this->get("STATUS_ID")->setMessages($validator->getMessages());
            $this->messages["STATUS_ID"] = $validator->getMessages();
        }
        
        return $valid && $extravalid;
    }
}