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

class HelpdeskTicketInputFilter implements InputFilterAwareInterface {
    
    private $inputFilter;
    
    public function setInputFilter (InputFilterInterface $inputFilter) {
        throw new DomainException(sprintf("%s does not allow injection of an input filter", __CLASS__));
    }
    
    public function getInputFilter() {
        if ($this->inputFilter) return $this->inputFilter;
        
        $inputFilter = new InputFilter();
        
        $inputFilter->add([
            "name" => "PRIORITY_ID",
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
                            NotEmpty::IS_EMPTY => "Priority Is Required",
                        ],
                    ],
                ],
                [ "name" => "Digits" ]
            ],
        ]);
        
        $inputFilter->add([
            "name" => "PC_NAME",
            "filters" => [
                [ "name" => StripTags::class ],
                [ "name" => StringTrim::class ],
            ],
            "validators" => [
                [ "name" => "NotEmpty",
                    "options" => [
                        "messages" => [
                            NotEmpty::IS_EMPTY => "PC Name Is Required",
                        ],
                    ],
                ],
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
            "name" => "LOCATION_ID",
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
                            NotEmpty::IS_EMPTY => "Location Is Required",
                        ],
                    ],
                ],
                [ "name" => "Digits" ]
            ],
        ]);
        
        $inputFilter->add([
            "name" => "VEHICLE_NUMBER",
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
            "name" => "PROBLEM_TYPE_ID",
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
                            NotEmpty::IS_EMPTY => "Problem Type Is Required",
                        ],
                    ],
                ],
                [ "name" => "Digits" ]
            ],
        ]);
        
        $inputFilter->add([
            "name" => "PROBLEM_DESCRIPTION",
            "required" => true,
            "filters" => [
                [ "name" => StripTags::class ],
                [ "name" => StringTrim::class ],
            ],
            "validators" => [
                [ "name" => "NotEmpty",
                    "options" => [
                        "messages" => [
                            NotEmpty::IS_EMPTY => "Problem Description Is Required",
                        ],
                    ],
                ],
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
            "name" => "ENTERED_BY",
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
                            GreaterThan::NOT_GREATER => "Entered As Has To Be Positive Integer",
                            GreaterThan::NOT_GREATER_INCLUSIVE => "Entered As Has To Be Positive Integer",
                        ],
                    ],
                    /* Break validation chain on failure */
                    "break_chain_on_failure" => true,
                ],
                [ "name" => "NotEmpty",
                    "options" => [
                        "type" => NotEmpty::INTEGER,
                        "messages" => [
                            NotEmpty::IS_EMPTY => "Entered As Is Required",
                        ],
                    ],
                ],
                [ "name" => "Digits" ]
            ],
        ]);
        
        /* Entered On Validation Not Required */
        $inputFilter->add([
            "name" => "ENTERED_ON",
            "required" => true,
            "validators" => [
                [ "name" => "NotEmpty",
                    "options" => [
                        "type" => NotEmpty::STRING,
                        "messages" => [
                            NotEmpty::IS_EMPTY => "Entered On Is Required",
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