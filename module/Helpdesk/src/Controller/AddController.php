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
use Helpdesk\Form\HelpdeskTicketInputFilter;
use Helpdesk\Model\HelpdeskTicketTable;
use Helpdesk\Model\HelpdeskTicketDTO;
use Helpdesk\Model\HelpdeskPriorityTable;
use Helpdesk\Model\HelpdeskLocationTable;
use Helpdesk\Model\HelpdeskProblemTypeTable;
use Helpdesk\Model\HelpdeskStatusTable;
use Helpdesk\Permissions\Acl\HelpdeskAcl;

class AddController extends AbstractActionController
{
    private $acl;
    private $ticketTable;
    private $priorityTable;
    private $locationTable;
    private $problemTypeTable;
    private $statusTable;
    
    public function __construct(HelpdeskAcl $acl,
                                HelpdeskTicketTable $ticketTable,
                                HelpdeskPriorityTable $priorityTable,
                                HelpdeskLocationTable $locationTable,
                                HelpdeskProblemTypeTable $problemTypeTable,
                                HelpdeskStatusTable $statusTable) {
        $this->acl = $acl;
        
        $this->ticketTable = $ticketTable;
        $this->priorityTable = $priorityTable;
        $this->locationTable = $locationTable;
        $this->problemTypeTable = $problemTypeTable;
        $this->statusTable = $statusTable;
    }
    
    public function indexAction() {
        //var_dump("Helpdesk Add Index");
        
        $form = new HelpdeskTicketForm($this->priorityTable->getLookupList(),
                                       $this->locationTable->getLookupList(),
                                       $this->problemTypeTable->getLookupList(),
                                       $this->statusTable->getLookupList());
        
        if ($this->getRequest()->isPost()) {
            $this->getRequest()->getPost()->set("PC_NAME", "TEST PC");
            $this->getRequest()->getPost()->set("STATUS_ID", $this->statusTable->getDefaultLookupId());
            $this->getRequest()->getPost()->set("ENTERED_ON", date("m/d/Y",time()));
            
            //var_dump($this->getRequest()->getPost());
            
            $form->setInputFilter((new HelpdeskTicketInputFilter())->getInputFilter());
            $form->setData($this->getRequest()->getPost());
            
            //var_dump($form->getMessages());
            
            if ($form->isValid()) {
                //var_dump($form->getMessages());
                
                $dto = new HelpdeskTicketDTO();
                $dto->exchangeArray($form->getData());
                
                //var_dump($dto);
                
                $this->ticketTable->createHelpdeskTicket($dto);
                $form = new HelpdeskTicketForm($this->priorityTable->getLookupList(),
                $this->locationTable->getLookupList(),
                $this->problemTypeTable->getLookupList(),
                $this->statusTable->getLookupList());

                return new ViewModel(["form" => $form, "message" => true]);
            }else {
                return new ViewModel(["form" => $form, "message" => false]);
            }
            
            //var_dump($form->getMessages());
        }
        
        return new ViewModel(["form" => $form,"message" => null]);
    }
}
