<?php

namespace Kutny\TracyBundle;

use Exception;
use Symfony\Component\Console\Event\ConsoleExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tracy\Debugger;

class KernelExceptionListener
{

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!$this->isNotFoundException($exception) && !$this->isAccessDeniedHttpException($exception)) {
            ob_start();
            Debugger::_exceptionHandler($exception, true);
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
}
