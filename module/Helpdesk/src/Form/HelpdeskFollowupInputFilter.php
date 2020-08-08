<?php

namespace Helpdesk\Form;

use DomainException;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\GreaterThan;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\StringLength;

class HelpdeskFollowupInputFilter implements InputFilterAwareInterface {
    
    private $inputFilter;
    
    public function setInputFilter (InputFilterInterface $inputFilter) {
        throw new DomainException(sprintf("%s does not allow injection of an input filter", __CLASS__));
    }
    
    public function getInputFilter() {
        if ($this->inputFilter) return $this->inputFilter;
        
        $inputFilter = new InputFilter();
        
        $inputFilter->add([
            "name" => "TICKET_ID",
            "required" => true,
            "filters" => [ [ "name" => ToInt::class ] ],
            "validators" => [
                [ "name" => "GreaterThan",
                    "options" => [
                        "min" => 0,
                        "inclusive" => false,
                        "messages" => [
                            GreaterThan::NOT_GREATER => "Value Not In List",
                            GreaterThan::NOT_GREATER_INCLUSIVE => "Value Not In List",
                        ],
                    ],
                    /* Break validation chain on failure */
                    "break_chain_on_failure" => true,
                ],
                [ "name" => "NotEmpty",
                    "options" => [
                        "type" => NotEmpty::INTEGER,
                        "messages" => [
                            NotEmpty::IS_EMPTY => "Ticket Number Is Required",
                        ],
                    ],
                ],
                [ "name" => "Digits" ]
            ],
        ]);
        
        $inputFilter->add([
            "name" => "STATUS_ID",
            "required" => true,
            "filters" => [ [ "name" => ToInt::class ] ],
            "validators" => [
                [ "name" => "GreaterThan",
                    "options" => [
                        "min" => 0,
                        "inclusive" => false,
                        "messages" => [
                            GreaterThan::NOT_GREATER => "Value Not In List",
                            GreaterThan::NOT_GREATER_INCLUSIVE => "Value Not In List",
                        ],
                    ],
                    /* Break validation chain on failure */
                    "break_chain_on_failure" => true,
                ],
                [ "name" => "NotEmpty",
                    "options" => [
                        "type" => NotEmpty::INTEGER,
                        "messages" => [
                            NotEmpty::IS_EMPTY => "Status Is Required",
                        ],
                    ],
                ],
                [ "name" => "Digits" ]
            ],
        ]);
        
        $inputFilter->add([
            "name" => "FOLLOWUP_TEXT",
            "filters" => [
                [ "name" => StripTags::class ],
                [ "name" => StringTrim::class ],
            ],
            "validators" => [
                [ "name" => "StringLength",
                    "options" => [
                        "encoding" => "UTF-8", "min" => 0, "max" => 10,
                        "messages" => [
                            StringLength::INVALID => "Only String Types Are Allowed",
                            StringLength::TOO_SHORT => "Value is too short %length% / %min%",
                            StringLength::TOO_LONG => "Value is too long %length% / %max%",
                        ],
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            "name" => "FOLLOWUP_BY",
            "required" => true,
            "filters" => [
                [ "name" => ToInt::class ]
            ],
            "validators" => [
                [ "name" => "GreaterThan",
                    "options" => [
                        "min" => 0,
                        "inclusive" => false,
                        "messages" => [
                            GreaterThan::NOT_GREATER => "Followup As Has To Be Positive Integer",
                            GreaterThan::NOT_GREATER_INCLUSIVE => "Followup As Has To Be Positive Integer",
                        ],
                    ],
                    /* Break validation chain on failure */
                    "break_chain_on_failure" => true,
                ],
                [ "name" => "NotEmpty",
                    "options" => [
                        "type" => NotEmpty::INTEGER,
                        "messages" => [
                            NotEmpty::IS_EMPTY => "Followup As Is Required",
                        ],
                    ],
                ],
                [ "name" => "Digits" ]
            ],
        ]);
        
        $inputFilter->add([
            "name" => "FOLLOWUP_ON",
            "required" => true,
            "validators" => [
                [ "name" => "NotEmpty",
                    "options" => [
                        "type" => NotEmpty::STRING,
                        "messages" => [
                            NotEmpty::IS_EMPTY => "Followups On Is Required",
                        ],
                    ],
                ],
                [ "name" => "Date",
                    "options" => [
                        "format" => "m/d/Y",
                    ],
                ],
            ],
        ]);
        
        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}