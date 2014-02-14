<?php

namespace Kutny\TracyBundle;

use Exception;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tracy\Debugger;

class KernelExceptionListener
{
    /** string */
    private $logDirectory;

    public function __construct($logDirectory)
    {
        $this->logDirectory = $logDirectory;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!$this->isNotFoundException($exception) && !$this->isAccessDeniedHttpException($exception)) {
            Debugger::$logDirectory = $this->logDirectory;
            Debugger::_exceptionHandler($exception, true);
        }
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
