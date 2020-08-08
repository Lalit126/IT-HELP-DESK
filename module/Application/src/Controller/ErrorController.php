<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ErrorController extends AbstractActionController
{
    public function indexAction()
    {
        //return $this->redirect()->toUrl("/error/privileges");
    }
    
    public function privilegesAction() {
        return new ViewModel([
            "message" => "Error: Insufficient Privileges",
            "reason" => "The page you requested required a privilege which your account does not have. Please contact the Information Systems Unit if you believe this to be in error."
        ]);
    }
}
