<?php
namespace Kutny\TracyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('kutny_tracy');

        $rootNode
            ->children()
                ->arrayNode('emails')
                    ->isRequired()
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('exceptions_directory')
                    ->defaultNull()
                ->end()
                ->scalarNode('store_username_in_server_variable')
                    ->defaultNull()
                ->end()
                ->arrayNode('ignored_exceptions')
                    ->prototype('scalar')->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
