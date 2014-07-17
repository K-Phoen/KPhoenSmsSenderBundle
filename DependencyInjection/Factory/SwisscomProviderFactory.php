<?php

namespace KPhoen\SmsSenderBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Swisscom provider factory
 *
 * @author Kévin Gomez <contact@kevingomez.fr>
 */
class SwisscomProviderFactory implements ProviderFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $container->getDefinition($id)
            ->replaceArgument(1, $config['client_id'])
            ->replaceArgument(2, $config['international_prefix'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'swisscom';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('client_id')->isRequired()->end()
                ->scalarNode('international_prefix')->defaultValue('+41')->end()
            ->end()
        ;
    }
}
