<?php

namespace Kutny\TracyBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class KutnyTracyExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $dir = $config['exceptions_directory'];
        if (null === $dir) {
            $dir = $container->getParameter('kernel.logs_dir') . '/exceptions';
        }

        $storeUsernameInServerVariable = $config['store_username_in_server_variable'];

        if (null === $storeUsernameInServerVariable)
        {
            $storeUsernameInServerVariable = false;
        }

        $container->setParameter('kutny_tracy.exceptions_directory', $dir);
        $container->setParameter('kutny_tracy.emails', $config['emails']);
        $container->setParameter('kutny_tracy.store_username_in_server_variable', $storeUsernameInServerVariable);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        if (false !== $dir) {
            $fs = new Filesystem();

            $fs->mkdir($dir);
        }

        $defaultIgnoredExceptions = array(
            'Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException',
            'Symfony\Component\HttpKernel\Exception\NotFoundHttpException',
        );

        foreach ($defaultIgnoredExceptions as $exception) {
            if (!in_array($exception, $config['ignored_exceptions'], true)) {
                $config['ignored_exceptions'][] = $exception;
            }
        }

        foreach ($config['ignored_exceptions'] as $exception) {
            $this->testExceptionExists($exception);
        }

        sort($config['ignored_exceptions']);
        
        $container->setParameter('kutny_tracy.ignored_exceptions', array_fill_keys($config['ignored_exceptions'], 1));
    }

    /**
     * Checks if an exception is loadable.
     *
     * @param string $exception Class to test
     *
     * @throws \InvalidArgumentException if the class was not found.
     */
    private function testExceptionExists($exception)
    {
        if (!is_subclass_of($exception, '\Exception') && !is_a($exception, '\Exception', true)) {
            throw new \InvalidArgumentException("KutnyTracyBundle exception mapper: Could not load class '$exception' or the class does not extend from '\Exception'. Most probably this is a configuration problem.");
        }
    }
}
