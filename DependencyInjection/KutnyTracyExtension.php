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
        $container->setParameter('kutny_tracy.exceptions_directory', $dir);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        if (false !== $dir) {
            $fs = new Filesystem();

            $fs->mkdir($dir);
        }
    }

}
