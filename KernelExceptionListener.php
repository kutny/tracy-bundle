<?php

namespace Kutny\TracyBundle;

use Exception;
use Symfony\Component\Console\Event\ConsoleExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\SecurityContext;
use Tracy\Debugger;

class KernelExceptionListener
{
    private $storeUsernameInServerVariable;
    private $securityContext;

    public function __construct($storeUsernameInServerVariable, SecurityContext $securityContext)
    {
        $this->storeUsernameInServerVariable = $storeUsernameInServerVariable;
        $this->securityContext = $securityContext;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!$this->isNotFoundException($exception) && !$this->isAccessDeniedHttpException($exception)) {
            if ($this->storeUsernameInServerVariable)
            {
                $this->storeUsernameInServerVariable();
            }

            ob_start();
            Debugger::exceptionHandler($exception, true);
            $event->setResponse(new Response(ob_get_contents()));
            ob_clean();
        }
    }

    public function onConsoleException(ConsoleExceptionEvent $event)
    {
        $exception = $event->getException();

        Debugger::log($exception, Debugger::ERROR);
    }

    private function isNotFoundException(Exception $exception)
    {
        return $exception instanceOf NotFoundHttpException;
    }

    private function isAccessDeniedHttpException(Exception $exception)
    {
        return $exception instanceOf AccessDeniedHttpException;
    }

    private function storeUsernameInServerVariable()
    {
        $token = $this->securityContext->getToken();

        if ($token) {
            $_SERVER['SYMFONY_USERNAME'] = $token->getUsername();
        }
    }
}
