<?php

namespace Kutny\TracyBundle;

use Exception;
use Symfony\Component\Console\Event\ConsoleExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Security\Core\SecurityContext;
use Tracy\Debugger;

class KernelExceptionListener
{
    private $storeUsernameInServerVariable;
    private $securityContext;
    /** @var  array */
    private $ignoredExceptions;

    public function __construct($storeUsernameInServerVariable, SecurityContext $securityContext, array $ignoredExceptions)
    {
        $this->storeUsernameInServerVariable = $storeUsernameInServerVariable;
        $this->securityContext = $securityContext;
        $this->ignoredExceptions = $ignoredExceptions;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (Debugger::isEnabled() && !$this->isIgnoredException($exception)) {
            if ($this->storeUsernameInServerVariable) {
                $this->storeUsernameInServerVariable();
            }

            if (Debugger::$productionMode === true) {
                Debugger::log($exception, Debugger::ERROR);
            }
            else if (Debugger::$productionMode === false) {
                ob_start();
                Debugger::exceptionHandler($exception, true);
                $event->setResponse(new Response(ob_get_contents()));
                ob_clean();
            }
        }
    }

    public function onConsoleException(ConsoleExceptionEvent $event)
    {
        $exception = $event->getException();

        Debugger::log($exception, Debugger::ERROR);
    }

    private function isIgnoredException(Exception $exception)
    {
        return isset($this->ignoredExceptions[get_class($exception)]);
    }

    private function storeUsernameInServerVariable()
    {
        $token = $this->securityContext->getToken();

        if ($token) {
            $_SERVER['SYMFONY_USERNAME'] = $token->getUsername();
        }
    }
}
