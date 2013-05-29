Tracy PHP debugger bundle for Symfony
=====================================

This bundle adds powerfull [Tracy debug tool](https://github.com/nette/tracy) to Symfony2 framework.

Tracy is a part of [Nette Framework](http://nette.org/).

![Nette Tracy screenshot](http://files.nette.org/2398/debugger1.png)

Installation
------------

1) Add __kutny/tracy-bundle__ to your composer.json.

~~~~~ json
"require": {
    "kutny/tracy-bundle": "dev-master"
}
~~~~~

2) Add KutnyTracyBundle to your application kernel

~~~~~ php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new Kutny\TracyBundle\KutnyTracyBundle(),
        // ...
    );
}
~~~~~

Configuration
-------------

Open web/app.php and add the following code **before** the _AppKernel_ class is instantiated:

~~~~~ php
\Tracy\Debugger::enable();
~~~~~

You may also need to disable Tracy debug bar which appears in the right-bottom corner of the screen:

~~~~~ php
\Tracy\Debugger::$bar = false;
~~~~~

I also recommend you to enable Tracy in a strict mode so it can handle errors of type E_NOTICE and E_WARNING too.

~~~~~ php
\Tracy\Debugger::$strictMode = true;
~~~~~

**Production mode**:

General [Server error page](http://files.nette.org/2398/debugger3.png) will be displayed if you enable the Debugger in the production mode. All errors/exceptions will be stored in _app/logs_ directory and sent to errors@mycompany.com.

~~~~~ php
\Tracy\Debugger::enable(Debugger::PRODUCTION, __DIR__ . '/logs/', 'errors@mycompany.com');
~~~~~

-------------

License
=======

https://github.com/kutny/autowiring-bundle/blob/master/LICENSE