<?php

namespace KPhoen\SmsSenderBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Interface that must be implemented by the provider factories
 *
 * @author Kévin Gomez <contact@kevingomez.fr>
 */
interface ProviderFactoryInterface
{
    /**
     * Creates the adapter, registers it and returns its id
     *
     * @param ContainerBuilder $container A ContainerBuilder instance
     * @param string $id The id of the service
     * @param array $config An array of configuration
     */
    public function create(ContainerBuilder $container, $id, array $config);

    /**
     * Returns the key for the factory configuration
     *
     * @return string
     */
    public function getKey();

    /**
     * Adds configuration nodes for the factory
     *
     * @param NodeDefinition $builder
     */
    public function addConfiguration(NodeDefinition $builder);
}
