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

class EditController extends AbstractActionController
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
        //var_dump("Helpdesk Edit Index");
        
        $id = $this->params()->fromRoute("id");
        
        $form = new HelpdeskTicketForm($this->priorityTable->getLookupList(),
                                       $this->locationTable->getLookupList(),
                                       $this->problemTypeTable->getLookupList(),
                                       $this->statusTable->getLookupList());
        
        if (isset($id) && is_numeric($id)) {
            //var_dump($id);
            $ticket = $this->ticketTable->getHelpdeskTicket($id);
            //var_dump($ticket);
            
            if ($this->getRequest()->isPost()) {
                // TEST
                $_POST["PC_NAME"] = "TEST PC";
                $this->getRequest()->getPost()->set("PC_NAME", "TEST PC");
                
                //var_dump($this->getRequest()->getPost());
                
                $form->setInputFilter((new HelpdeskTicketInputFilter())->getInputFilter());
                $form->setData($this->getRequest()->getPost());
                
                //var_dump($form->getMessages());
                
                if ($form->isValid()) {
                    //var_dump($form->getMessages());
                    
                    $dto = new HelpdeskTicketDTO();
                    $dto->exchangeArray($form->getData());
                    
                    //var_dump($dto);
                    
                    $this->ticketTable->updateHelpdeskTicket($dto);
                }
                
                //var_dump($form->getMessages());
            } else {
                $form->setData($ticket->toArray());
            }
            
            return new ViewModel(["id" => $id,  "form" => $form]);
        } else {
            return $this->redirect()->toRoute("access_denied");
        }
    }
}
