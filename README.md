Tracy PHP debugger bundle for Symfony
=====================================

This bundle adds powerfull [Tracy debug tool](http://doc.nette.org/en/debugging) to Symfony2 framework.

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

See the [full docs](Read docs at http://doc.nette.org/en/debugging) for more options.

License
=======

https://github.com/kutny/autowiring-bundle/blob/master/LICENSE