Tracy PHP debugger bundle for Symfony
=====================================

This bundle adds the powerful [Tracy debug tool](https://github.com/nette/tracy) to the Symfony2 framework.

[![Nette Tracy screenshot](http://nette.github.io/tracy/images/tracy-exception.png)](http://nette.github.io/tracy/tracy-exception.html)

**Why is Tracy better than the Symfony build-in debugger?**

* Exception stack trace contains values of all method arguments.
* Request & Response & Server environment information is displayed on the error page.
* The whole error page with full stack trace can be easily stored to some directory as HTML file (useful on production mode).
* Webmaster can be notified by email about errors that occured on the site.

See [full Tracy docs](https://github.com/nette/tracy) and [sample error page](http://nette.github.io/tracy/tracy-exception.html).

Tracy is a part of the [Nette Framework](http://nette.org/).

Installation
------------

1) Add __kutny/tracy-bundle__ to your composer.json.

~~~~~ json
"require": {
    "kutny/tracy-bundle": "dev-master"
}
~~~~~

2) Add KutnyTracyBundle to your application kernel.
For This bundle to catch as many errors as possible it should be the first bundle in the bundles array.

~~~~~ php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        new Kutny\TracyBundle\KutnyTracyBundle(),
        // ...
    );
}
~~~~~

Configuration
-------------

**1) app.php / app_dev.php**

Open *web/app.php* and *web/app_dev.php* files and add the following code **before** the _AppKernel_ class is instantiated:

~~~~~ php
\Tracy\Debugger::enable();
~~~~~

Or force the **production mode** where only [general server error page](http://nette.github.io/tracy/images/tracy-error2.png) will be displayed to the user ([read more](https://github.com/nette/tracy#production-mode-and-error-logging)):

~~~~~ php
\Tracy\Debugger::enable(\Tracy\Debugger::PRODUCTION);
~~~~~

I also recommend you to enable Tracy in a strict mode so it can handle errors of type E_NOTICE and E_WARNING too.

~~~~~ php
\Tracy\Debugger::$strictMode = true;
~~~~~

**2) config.yml**

~~~~~ yaml
kutny_tracy:
    emails: ['errors@mycompany.com'] # error notification recipients
    exceptions_directory: <directory> # optional, default directory set to %kernel.logs_dir%/exceptions
    store_username_in_server_variable: true|false # optional, default value = false; stores username of logged user in $_SERVER['SYMFONY_USERNAME'] - helps you to find out which user encountered the error

~~~~~

-------------

License
=======

This bundle license: https://github.com/kutny/tracy-bundle/blob/master/LICENSE

Tracy debugger license: https://github.com/nette/tracy/blob/master/license.md