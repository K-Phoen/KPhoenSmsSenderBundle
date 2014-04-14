<?php

namespace KPhoen\SmsSenderBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * ValueFirst provider factory
 *
 * @author Kévin Gomez <contact@kevingomez.fr>
 */
class ValueFirstProviderFactory implements ProviderFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $container->getDefinition($id)
            ->replaceArgument(1, $config['username'])
            ->replaceArgument(2, $config['password'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'valuefirst';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('username')->isRequired()->end()
                ->scalarNode('password')->isRequired()->end()
            ->end()
        ;
    }
}
