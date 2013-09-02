<?php

namespace KPhoen\SmsSenderBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Dummy provider factory
 *
 * @author Kévin Gomez <contact@kevingomez.fr>
 */
class DummyProviderFactory implements ProviderFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'dummy';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
    }
}
