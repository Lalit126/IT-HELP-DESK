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
use Helpdesk\Form\HelpdeskTicketForm;
use Helpdesk\Form\HelpdeskFollowupForm;
use Helpdesk\Permissions\Acl\HelpdeskAcl;
use Helpdesk\Model\HelpdeskTicketTable;
use Helpdesk\Model\HelpdeskPriorityTable;
use Helpdesk\Model\HelpdeskLocationTable;
use Helpdesk\Model\HelpdeskProblemTypeTable;
use Helpdesk\Model\HelpdeskStatusTable;
use Helpdesk\Model\HelpdeskFollowupStatusTable;

class ViewController extends AbstractActionController
{
    private $acl;
    private $ticketTable;
    private $priorityTable;
    private $locationTable;
    private $problemTypeTable;
    private $statusTable;
    private $followupStatusTable;
    
    public function __construct(HelpdeskAcl $acl,
                                HelpdeskTicketTable $ticketTable,
                                HelpdeskPriorityTable $priorityTable,
                                HelpdeskLocationTable $locationTable,
                                HelpdeskProblemTypeTable $problemTypeTable,
                                HelpdeskStatusTable $statusTable,
                                HelpdeskFollowupStatusTable $followupStatusTable) {
        $this->acl = $acl;
        
        $this->ticketTable = $ticketTable;
        $this->priorityTable = $priorityTable;
        $this->locationTable = $locationTable;
        $this->problemTypeTable = $problemTypeTable;
        $this->statusTable = $statusTable;
        $this->followupStatusTable = $followupStatusTable;
    }
    
    public function indexAction()
    {
        //var_dump("Helpdesk View Index");
        
        $id = $this->params()->fromRoute("id");
        
        $form = new HelpdeskTicketForm($this->priorityTable->getLookupList(),
                                       $this->locationTable->getLookupList(),
                                       $this->problemTypeTable->getLookupList(),
                                       $this->statusTable->getLookupList());
        
        $followupform = new HelpdeskFollowupForm($id, $this->followupStatusTable->getLookupList());
        
        if (isset($id) && is_numeric($id)) {            
            //var_dump($id);
            $ticket = $this->ticketTable->getHelpdeskTicket($id);
            //var_dump($ticket);
            
            return new ViewModel(["id" => $id, "ticket" => $ticket,
                                  "form" => $form,
                                  "followupform" => $followupform]);
        } else {
            return $this->redirect()->toRoute("access_denied");
        }
        
        
    }
}
