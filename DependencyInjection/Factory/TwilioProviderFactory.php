<?php

namespace KPhoen\SmsSenderBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Twilio provider factory
 *
 * @author Kévin Gomez <contact@kevingomez.fr>
 */
class TwilioProviderFactory implements ProviderFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $container->getDefinition($id)
            ->replaceArgument(1, $config['accountSid'])
            ->replaceArgument(2, $config['apiSecret'])
            ->replaceArgument(3, $config['internationalPrefix'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'twilio';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('accountSid')->isRequired()->end()
                ->scalarNode('apiSecret')->isRequired()->end()
                ->scalarNode('internationalPrefix')->defaultValue('+33')->end()
            ->end()
        ;
    }
}
