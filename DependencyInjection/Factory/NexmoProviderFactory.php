<?php

namespace KPhoen\SmsSenderBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Nexmo provider factory
 *
 * @author Kévin Gomez <contact@kevingomez.fr>
 */
class NexmoProviderFactory implements ProviderFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $container->getDefinition($id)
            ->replaceArgument(1, $config['api_key'])
            ->replaceArgument(2, $config['api_secret'])
            ->replaceArgument(3, $config['international_prefix'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'nexmo';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('api_key')->isRequired()->end()
                ->scalarNode('api_secret')->isRequired()->end()
                ->scalarNode('international_prefix')->defaultValue('+33')->end()
            ->end()
        ;
    }
}
