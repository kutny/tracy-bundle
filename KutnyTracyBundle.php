<?php

namespace Kutny\TracyBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tracy\Debugger;

class KutnyTracyBundle extends Bundle
{

    public function boot()
    {
        Debugger::$logDirectory = $this->container->getParameter('kutny_tracy.exceptions_directory');
        Debugger::$email = $this->container->getParameter('kutny_tracy.emails');
    }

}
