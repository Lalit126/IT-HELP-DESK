<?php

namespace Helpdesk\Permissions\Acl;

use Laminas\Permissions\Acl\Acl;
use Laminas\Permissions\Acl\Role\GenericRole;
use Laminas\Permissions\Acl\Resource\GenericResource;

class HelpdeskAcl extends Acl
{
    private $acl;
    
    public function __construct() {
        //var_dump("Creating Acls");
        
        $acl = new Acl();
    }
}