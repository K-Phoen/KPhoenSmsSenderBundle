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
            ->replaceArgument(1, $config['account_sid'])
            ->replaceArgument(2, $config['api_secret'])
            ->replaceArgument(3, $config['international_prefix'])
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
                ->scalarNode('account_sid')->isRequired()->end()
                ->scalarNode('api_secret')->isRequired()->end()
                ->scalarNode('international_prefix')->defaultValue('+33')->end()
            ->end()
        ;
    }
}
