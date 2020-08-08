<?php 

namespace Helpdesk\Model;

class HelpdeskTicketDTO {
    protected $TICKET_ID;
    protected $RESPONDERS;
    protected $PRIORITY_ID;
    protected $PRIORITY;
    protected $PC_NAME;
    protected $LOCATION_ID;
    protected $LOCATION;
    protected $VEHICLE_NUMBER;
    protected $PROBLEM_TYPE_ID;
    protected $PROBLEM_TYPE;
    protected $PROBLEM_DESCRIPTION;
    protected $FOLLOWUPS;
    protected $LATEST_FOLLOWUP;
    protected $STATUS_ID;
    protected $STATUS;
    protected $ENTERED_BY;
    protected $ENTERED_ON;
    protected $ENTERED_ON_DATE;
    protected $ENTERED_ON_DATETIME;
    protected $UPDATED_BY;
    protected $UPDATED_ON;
    protected $UPDATED_ON_DATE;
    protected $UPDATED_ON_DATETIME;
    
    public function exchangeArray(array $data)
    {
        $this->TICKET_ID = ((!empty($data["TICKET_ID"])) ? $data["TICKET_ID"] : null);
        $this->RESPONDERS = ((!empty($data["RESPONDERS"])) ? $data["RESPONDERS"] : null);
        $this->PRIORITY_ID = ((!empty($data["PRIORITY_ID"])) ? $data["PRIORITY_ID"] : null);
        $this->PC_NAME = ((!empty($data["PC_NAME"])) ? $data["PC_NAME"] : null);
        $this->LOCATION_ID = ((!empty($data["LOCATION_ID"])) ? $data["LOCATION_ID"] : null);
        $this->VEHICLE_NUMBER = ((!empty($data["VEHICLE_NUMBER"])) ? $data["VEHICLE_NUMBER"] : null);
        $this->PROBLEM_TYPE_ID = ((!empty($data["PROBLEM_TYPE_ID"])) ? $data["PROBLEM_TYPE_ID"] : null);
        $this->PROBLEM_DESCRIPTION = ((!empty($data["PROBLEM_DESCRIPTION"])) ? $data["PROBLEM_DESCRIPTION"] : null);
        $this->STATUS_ID = ((!empty($data["STATUS_ID"])) ? $data["STATUS_ID"] : null);
        $this->ENTERED_BY = ((!empty($data["ENTERED_BY"])) ? $data["ENTERED_BY"] : null);
        $this->ENTERED_ON = ((!empty($data["ENTERED_ON"])) ? $data["ENTERED_ON"] : null);
        $this->UPDATED_BY = ((!empty($data["UPDATED_BY"])) ? $data["UPDATED_BY"] : null);
        $this->UPDATED_ON = ((!empty($data["UPDATED_ON"])) ? $data["UPDATED_ON"] : null);
    }
    
    public function toArray() {
        return [
            "TICKET_ID" => $this->TICKET_ID,
            "PRIORITY_ID" => $this->PRIORITY_ID,
            "PC_NAME" => $this->PC_NAME,
            "LOCATION_ID" => $this->LOCATION_ID,
            "VEHICLE_NUMBER" => $this->VEHICLE_NUMBER,
            "PROBLEM_TYPE_ID" => $this->PROBLEM_TYPE_ID,
            "PROBLEM_DESCRIPTION" => $this->PROBLEM_DESCRIPTION,
            "STATUS_ID" => $this->STATUS_ID,
            "ENTERED_BY" => $this->ENTERED_BY,
            "ENTERED_ON" => $this->ENTERED_ON,
            "UPDATED_BY" => $this->UPDATED_BY,
            "UPDATED_ON" => $this->UPDATED_ON
        ];
    }
    
    public function getTicketId() {
        return $this->TICKET_ID;
    }
    
    public function getResponders() {
        return $this->RESPONDERS;
    }
    
    public function setResponders($responders) {
        $this->RESPONDERS = $responders;
    }
    
    public function getPriorityId() {
        return $this->PRIORITY_ID;
    }
    
    public function getPriority() {
        return $this->PRIORITY;
    }
    
    public function setPriority($priority) {
        $this->PRIORITY = $priority;
    }
    
    public function getPCName() {
        return $this->PC_NAME;
    }
    
    public function getLocationId() {
        return $this->LOCATION_ID;
    }
    
    public function getLocation() {
        return $this->LOCATION;
    }
    
    public function setLocation($location) {
        $this->LOCATION = $location;
    }
    
    public function getVehicleNumber() {
        return $this->VEHICLE_NUMBER;
    }
    
    public function getProblemTypeId() {
        return $this->PROBLEM_TYPE_ID;
    }
    
    public function getProblemType() {
        return $this->PROBLEM_TYPE;
    }
    
    public function setProblemType($problemType) {
        $this->PROBLEM_TYPE = $problemType;
    }
    
    public function getProblemDescription() {
        return $this->PROBLEM_DESCRIPTION;
    }
    
    public function getFollowups() {
        return $this->FOLLOWUPS;
    }
    
    public function setFollowups($followups) {
        $this->FOLLOWUPS = $followups;
    }
    
    public function getLatestFollowup() {
        return $this->LATEST_FOLLOWUP;
    }
    
    public function setLatestFollowup($followup) {
        $this->LATEST_FOLLOWUP = $followup;
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
    
    public function getEnteredBy() {
        return $this->ENTERED_BY;
    }
    
    public function getEnteredOn() {
        return $this->ENTERED_ON;
    }
    
    public function getEnteredOn_Date() {
        return $this->ENTERED_ON_DATE;
    }
    
    public function getEnteredOn_DateTime() {
        return $this->ENTERED_ON_DATETIME;
    }
    
    public function setEnteredOn_Date($enteredon_date) {
        $this->ENTERED_ON_DATE = $enteredon_date;
    }
    
    public function setEnteredOn_DateTime($enteredon_datetime) {
        $this->ENTERED_ON_DATETIME = $enteredon_datetime;
    }
    
    public function getUpdatedBy() {
        return $this->UPDATED_BY;
    }
    
    public function getUpdatedOn() {
        return $this->UPDATED_ON;
    }
    
    public function getUpdatedOn_Date() {
        return $this->UPDATED_ON_DATE;
    }
    
    public function getUpdatedOn_DateTime() {
        return $this->UPDATED_ON_DATETIME;
    }
    
    public function setUpdatedOn_Date($updatedon_date) {
        $this->UPDATED_ON_DATE = $updatedon_date;
    }
    
    public function setUpdatedOn_DateTime($updatedon_datetime) {
        $this->UPDATED_ON_DATETIME = $updatedon_datetime;
    }
}