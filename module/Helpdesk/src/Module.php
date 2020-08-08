<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Helpdesk;

use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\EventManager\EventInterface;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\ServiceProviderInterface;
use Laminas\ModuleManager\Feature\ControllerProviderInterface;
use Laminas\ModuleManager\Feature\BootstrapListenerInterface;

class Module implements ConfigProviderInterface, ServiceProviderInterface, ControllerProviderInterface, BootstrapListenerInterface
{
    public function getConfig() : array
    {
        //var_dump("Main Module Config");
        
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function getServiceConfig() {
        //var_dump("Service Config");
        
        return [
            "factories" => [
                Permissions\Acl\HelpdeskAcl::class => function($container) {
                    //var_dump(new Permissions\Acl\HelpdeskAcl());
                    return new Permissions\Acl\HelpdeskAcl();
                },
                Model\HelpdeskTicketTable::class => function($container) {
                    $ticketTableGateway = $container->get(Model\HelpdeskTicketTableGateway::class);
                    /* Get Responder Table */
                    $responderTableGateway = $container->get(Model\HelpdeskResponderTableGateway::class);
                    $responderTable = new Model\HelpdeskResponderTable($responderTableGateway);
                    /* Get Followup Status Table */
                    $followupStatusTableGateway = $container->get(Model\HelpdeskFollowupStatusTableGateway::class);
                    $followupStatusTable = new Model\HelpdeskFollowupStatusTable($followupStatusTableGateway);
                    /* Get Followup Table */
                    $followupTableGateway = $container->get(Model\HelpdeskFollowupTableGateway::class);
                    $followupTable = new Model\HelpdeskFollowupTable($followupTableGateway, $followupStatusTable);
                    /* Get Priority Table */
                    $priorityTableGateway = $container->get(Model\HelpdeskPriorityTableGateway::class);
                    $priorityTable = new Model\HelpdeskPriorityTable($priorityTableGateway);
                    /* Get Location Table */
                    $locationTableGateway = $container->get(Model\HelpdeskLocationTableGateway::class);
                    $locationTable = new Model\HelpdeskLocationTable($locationTableGateway);
                    /* Get ProblemType Table */
                    $problemTypeTableGateway = $container->get(Model\HelpdeskProblemTypeTableGateway::class);
                    $problemTypeTable = new Model\HelpdeskProblemTypeTable($problemTypeTableGateway);
                    /* Get Status Table */
                    $statusTableGateway = $container->get(Model\HelpdeskStatusTableGateway::class);
                    $statusTable = new Model\HelpdeskStatusTable($statusTableGateway);
                    
                    return new Model\HelpdeskTicketTable($ticketTableGateway, $responderTable, $followupTable, $priorityTable, $locationTable, $problemTypeTable, $statusTable);
                },
                Model\HelpdeskPriorityTable::class => function($container) {
                    $priorityTableGateway = $container->get(Model\HelpdeskPriorityTableGateway::class);
                    
                    return new Model\HelpdeskPriorityTable($priorityTableGateway);
                },
                Model\HelpdeskLocationTable::class => function($container) {
                    $locationTableGateway = $container->get(Model\HelpdeskLocationTableGateway::class);
                    
                    return new Model\HelpdeskLocationTable($locationTableGateway);
                },
                Model\HelpdeskProblemTypeTable::class => function($container) {
                    $problemTypeTableGateway = $container->get(Model\HelpdeskProblemTypeTableGateway::class);
                    
                    return new Model\HelpdeskProblemTypeTable($problemTypeTableGateway);
                },
                Model\HelpdeskStatusTable::class => function($container) {
                    $statusTableGateway = $container->get(Model\HelpdeskStatusTableGateway::class);
                    
                    return new Model\HelpdeskStatusTable($statusTableGateway);
                },
                Model\HelpdeskFollowupStatusTable::class => function($container) {
                    $followupStatusTableGateway = $container->get(Model\HelpdeskFollowupStatusTableGateway::class);
                    
                    return new Model\HelpdeskFollowupStatusTable($followupStatusTableGateway);
                },
                Model\HelpdeskTicketTableGateway::class => function($container) {
                    $dbAdapter = $container->get("helpdesk");
                    $resultSetPrototype = new HydratingResultSet(new ReflectionHydrator, new Model\HelpdeskTicketDTO);
                    
                    return new TableGateway("HELPDESK_TICKETS", $dbAdapter, null, $resultSetPrototype);
                },
                Model\HelpdeskResponderTableGateway::class => function($container) {
                    $dbAdapter = $container->get("helpdesk");
                    $resultSetPrototype = new HydratingResultSet(new ReflectionHydrator, new Model\HelpdeskResponderDTO);
                    
                    return new TableGateway("HELPDESK_RESPONDERS", $dbAdapter, null, $resultSetPrototype);
                },
                Model\HelpdeskFollowupTableGateway::class => function ($container) {
                    $dbAdapter = $container->get("helpdesk");
                    $resultSetPrototype = new HydratingResultSet(new ReflectionHydrator, new Model\HelpdeskFollowupDTO);
                    
                    return new TableGateway("HELPDESK_FOLLOWUPS", $dbAdapter, null, $resultSetPrototype);
                },
                Model\HelpdeskFollowupStatusTableGateway::class => function ($container) {
                    $dbAdapter = $container->get("helpdesk");
                    $resultSetPrototype = new HydratingResultSet(new ReflectionHydrator, new Model\HelpdeskFollowupStatusDTO);
                    
                    return new TableGateway("HELPDESK_FOLLOWUP_STATUSES", $dbAdapter, null, $resultSetPrototype);
                },
                Model\HelpdeskPriorityTableGateway::class => function ($container) {
                    $dbAdapter = $container->get("helpdesk");
                    $resultSetPrototype = new HydratingResultSet(new ReflectionHydrator, new Model\HelpdeskPriorityDTO);
                    
                    return new TableGateway("HELPDESK_PRIORITIES", $dbAdapter, null, $resultSetPrototype);
                },
                Model\HelpdeskLocationTableGateway::class => function ($container) {
                    $dbAdapter = $container->get("helpdesk");
                    $resultSetPrototype = new HydratingResultSet(new ReflectionHydrator, new Model\HelpdeskLocationDTO);
                    
                    return new TableGateway("HELPDESK_LOCATIONS", $dbAdapter, null, $resultSetPrototype);
                },
                Model\HelpdeskProblemTypeTableGateway::class => function ($container) {
                    $dbAdapter = $container->get("helpdesk");
                    $resultSetPrototype = new HydratingResultSet(new ReflectionHydrator, new Model\HelpdeskProblemTypeDTO);
                    
                    return new TableGateway("HELPDESK_PROBLEM_TYPES", $dbAdapter, null, $resultSetPrototype);
                },
                Model\HelpdeskStatusTableGateway::class => function ($container) {
                    $dbAdapter = $container->get("helpdesk");
                    $resultSetPrototype = new HydratingResultSet(new ReflectionHydrator, new Model\HelpdeskStatusDTO);
                    
                    return new TableGateway("HELPDESK_STATUSES", $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }
    
    public function getControllerConfig() {
        //var_dump("Controller Config");
        
        return [
            "factories" => [
                Controller\IndexController::class => function($container) {
                    //var_dump("Creating IndexController");
                    return new Controller\IndexController($container->get(Permissions\Acl\HelpdeskAcl::class),
                                                          $container->get(Model\HelpdeskTicketTable::class));
                },
                Controller\AddController::class => function($container) {
                    //var_dump("Creating AddController");
                    ////var_dump(new Model\HelpdeskStatusTable($container->get(Model\HelpdeskStatusTableGateway::class)));
                    //var_dump($container->get(Permissions\Acl\HelpdeskAcl::class));
                    return new Controller\AddController($container->get(Permissions\Acl\HelpdeskAcl::class),
                                                        $container->get(Model\HelpdeskTicketTable::class),
                                                        $container->get(Model\HelpdeskPriorityTable::class),
                                                        $container->get(Model\HelpdeskLocationTable::class),
                                                        $container->get(Model\HelpdeskProblemTypeTable::class),
                                                        $container->get(Model\HelpdeskStatusTable::class));
                },
                Controller\ViewController::class => function($container) {
                    //var_dump("Creating ViewController");
                    return new Controller\ViewController($container->get(Permissions\Acl\HelpdeskAcl::class),
                                                         $container->get(Model\HelpdeskTicketTable::class),
                                                         $container->get(Model\HelpdeskPriorityTable::class),
                                                         $container->get(Model\HelpdeskLocationTable::class),
                                                         $container->get(Model\HelpdeskProblemTypeTable::class),
                                                         $container->get(Model\HelpdeskStatusTable::class),
                                                         $container->get(Model\HelpdeskFollowupStatusTable::class));
                },
                Controller\EditController::class => function($container) {
                    //var_dump("Creating EditController");
                    return new Controller\EditController($container->get(Permissions\Acl\HelpdeskAcl::class),
                                                         $container->get(Model\HelpdeskTicketTable::class),
                                                         $container->get(Model\HelpdeskPriorityTable::class),
                                                         $container->get(Model\HelpdeskLocationTable::class),
                                                         $container->get(Model\HelpdeskProblemTypeTable::class),
                                                         $container->get(Model\HelpdeskStatusTable::class));
                },
            ],
        ];
    }
    
    public function onBootstrap(EventInterface $e) {
        //var_dump("Bootstrapping Helpdesk");
        
        /*
        return [
            "factories" => [
                Permissions\Acl\HelpdeskAcl::class => function($container) {
                    //var_dump(new Permissions\Acl\HelpdeskAcl());
                    return new Permissions\Acl\HelpdeskAcl();
                },
            ],
        ];
        */
    }
}
