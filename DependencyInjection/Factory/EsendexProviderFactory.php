<?php

namespace KPhoen\SmsSenderBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Esendex provider factory
 *
 * @author Kévin Gomez <contact@kevingomez.fr>
 */
class EsendexProviderFactory implements ProviderFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $container->getDefinition($id)
            ->replaceArgument(1, $config['username'])
            ->replaceArgument(2, $config['password'])
            ->replaceArgument(3, $config['accountRef'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'esendex';
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
                ->scalarNode('accountRef')->isRequired()->end()
            ->end()
        ;
    }
}
