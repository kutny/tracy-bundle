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
    }

}
