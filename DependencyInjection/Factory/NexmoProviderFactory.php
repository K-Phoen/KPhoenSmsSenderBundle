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
            ->replaceArgument(1, $config['apiKey'])
            ->replaceArgument(2, $config['apiSecret'])
            ->replaceArgument(3, $config['internationalPrefix'])
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
                ->scalarNode('apiKey')->isRequired()->end()
                ->scalarNode('apiSecret')->isRequired()->end()
                ->scalarNode('internationalPrefix')->defaultValue('+33')->end()
            ->end()
        ;
    }
}
