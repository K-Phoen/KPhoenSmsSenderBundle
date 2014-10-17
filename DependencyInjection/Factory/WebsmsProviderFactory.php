<?php

namespace KPhoen\SmsSenderBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * websms provider factory
 *
 * @author Thomas Konrad <tkonrad@gmx.net>
 */
class WebsmsProviderFactory implements ProviderFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $container->getDefinition($id)
            ->replaceArgument(1, $config['access_token'])
            ->replaceArgument(2, $config['international_prefix'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'websms';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
            ->scalarNode('access_token')->isRequired()->end()
            ->scalarNode('international_prefix')->defaultValue('+43')->end()
            ->end()
        ;
    }
}
