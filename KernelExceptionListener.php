<?php

namespace Kutny\TracyBundle;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Tracy\Debugger;

class KernelExceptionListener
{

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        Debugger::_exceptionHandler($event->getException());
    }
}
