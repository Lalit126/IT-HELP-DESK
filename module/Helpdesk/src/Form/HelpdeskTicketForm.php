<?php 

namespace Helpdesk\Form;

use Laminas\Form\Form;
use Laminas\Validator\LessThan;

class HelpdeskTicketForm extends Form {
    public function __construct($priorities, $locations, $problemtypes, $statuses, $name = null, $options=[]) {
        parent::__construct($name, $options);
        
        $this->add([
            "name" => "PRIORITY_ID",
            "type" => "Select",
            "class" => "form-control",
            "options" => [
                "label" => "Priority",
                /* Ignore notInArray : The input was not found in the haystack */
                "disable_inarray_validator" => true,
                "value_options" => $priorities,
            ],
        ]);
        
        $this->add([
            "name" => "PC_NAME",
            "type" => "Text",
            "class" => "form-control",
            "placeholder" => "Vehicle Number",
            "options" => [
                "label" => "PC Name",
            ],
        ]);
        
        $this->add([
            "name" => "LOCATION_ID",
            "type" => "Select",
            "class" => "form-control",
            "options" => [
                "label" => "Location",
                /* Ignore notInArray : The input was not found in the haystack */
                "disable_inarray_validator" => true,
                "value_options" => $locations,
            ],
        ]);
        
        $this->add([
            "name" => "VEHICLE_NUMBER",
            "type" => "Text",
            "class" => "form-control",
            "placeholder" => "Vehicle Number",
            "options" => [
                "label" => "Vehicle",
            ],
        ]);
        
        $this->add([
            "name" => "PROBLEM_TYPE_ID",
            "type" => "Select",
            "class" => "form-control",
            "options" => [
                "label" => "Problem Type",
                /* Ignore notInArray : The input was not found in the haystack */
                "disable_inarray_validator" => true,
                "value_options" => $problemtypes,
            ],
        ]);
        
        $this->add([
            "name" => "PROBLEM_DESCRIPTION",
            "type" => "Textarea",
            "required" => "true",
            "class" => "form-control",
            "style" => "resize: vertical;",
            "options" => [
                "label" => "Problem Description",
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
            "name" => "ENTERED_BY",
            "type" => "Text",
            "class" => "form-control",
            "placeholder" => "Entered As",
            "options" => [
                "label" => "Entered As",
            ],
        ]);
        
        $this->add([
            "name" => "ENTERED_ON",
            "type" => "Text",
            "class" => "form-control",
            "placeholder" => "Entered On",
            "options" => [
                "label" => "Entered On",
            ],
        ]);
        
        $this->add([
            "name" => "Submit",
            "type" => "Submit",
            "attributes" => [
                "value" => "Submit Helpdesk Ticket"
            ],
            
        ]);
    }
    
    //public function setData($data) {
        //parent::setData($data);
        
        ////var_dump($data);
        ////var_dump($this->get("LOCATION_ID")->getValue());
        ////var_dump($this->get("LOCATION_ID")->getValueOptions());
        
        //$this->get("LOCATION_ID")->setValue($data["LOCATION_ID"]);
    //}
    
    public function isValid() {
        $valid = parent::isValid();
        
        $extravalid = true;
        
        $data = $this->getData();
        
        //var_dump($data);
        
        /* Validate against maximum number of priorities */
        $max = count($this->get("PRIORITY_ID")->getOption("value_options"));
        $validator = new LessThan(["max" => "$max", "inclusive" => true]);
        $validator->setMessages([LessThan::NOT_LESS => "Value Not In List",
            LessThan::NOT_LESS_INCLUSIVE => "Value Not In List"]);
        
        $extravalid &= $validator->isValid($data["PRIORITY_ID"]);
        
        if ($validator->getMessages()) {
            $this->get("PRIORITY_ID")->setMessages($validator->getMessages());
            $this->messages["PRIORITY_ID"] = $validator->getMessages();
        }
        
        /* Validate against maximum number of locations */
        $max = count($this->get("LOCATION_ID")->getOption("value_options"));
        $validator = new LessThan(["max" => "$max", "inclusive" => true]);
        $validator->setMessages([LessThan::NOT_LESS => "Value Not In List",
                                 LessThan::NOT_LESS_INCLUSIVE => "Value Not In List"]);
        
        $extravalid &= $validator->isValid($data["LOCATION_ID"]);
        
        if ($validator->getMessages()) {
            $this->get("LOCATION_ID")->setMessages($validator->getMessages());
            $this->messages["LOCATION_ID"] = $validator->getMessages();
        }
        
        /* Validate against maximum number of problem types */
        $max = count($this->get("PROBLEM_TYPE_ID")->getOption("value_options"));
        $validator = new LessThan(["max" => "$max", "inclusive" => true]);
        $validator->setMessages([LessThan::NOT_LESS => "Value Not In List",
            LessThan::NOT_LESS_INCLUSIVE => "Value Not In List"]);
        
        $extravalid &= $validator->isValid($data["PROBLEM_TYPE_ID"]);
        
        if ($validator->getMessages()) {
            $this->get("PROBLEM_TYPE_ID")->setMessages($validator->getMessages());
            $this->messages["PROBLEM_TYPE_ID"] = $validator->getMessages();
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