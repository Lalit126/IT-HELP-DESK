<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Helpdesk\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Helpdesk\Model\HelpdeskTicketTable;
use Helpdesk\Permissions\Acl\HelpdeskAcl;

class IndexController extends AbstractActionController
{
    private $acl;
    private $ticketTable;
    
    public function __construct(HelpdeskAcl $acl,
                                HelpdeskTicketTable $ticketTable) {
        $this->acl = $acl;
        
        $this->ticketTable = $ticketTable;
    }
    
    public function indexAction()
    {
        //var_dump("Helpdesk Index");
        
        //var_dump($this->ticketTable->fetchUnassigned());
        
        //var_dump($this->ticketTable->fetchUnassigned()->getTotalItemCount());
        
        foreach ($this->ticketTable->fetchAll() as $helpdeskticket) //var_dump($helpdeskticket);
        
        foreach ($this->ticketTable->fetchUnassigned() as $helpdeskticket) //var_dump($helpdeskticket);
        
        foreach ($this->ticketTable->fetchFollowups() as $helpdeskticket) //var_dump($helpdeskticket);
        
        foreach ($this->ticketTable->fetchPending() as $helpdeskticket) //var_dump($helpdeskticket);
        
        foreach ($this->ticketTable->fetchOrdered() as $helpdeskticket) //var_dump($helpdeskticket);
        
        return new ViewModel(["unassigned" => $this->ticketTable->fetchUnassigned(),
                              "followups" => $this->ticketTable->fetchFollowups()]);
    }
}
