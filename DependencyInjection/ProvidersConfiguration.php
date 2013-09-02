<?php

namespace KPhoen\SmsSenderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ProvidersConfiguration implements ConfigurationInterface
{
    protected $factories = array();
    protected $providers = array();

    public function __construct(array $providers = array(), array $factories = array())
    {
        $this->providers = $providers;
        $this->factories = $factories;
    }

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('k_phoen_sms_sender');

        $this->addProvidersNode($rootNode);

        return $treeBuilder;
    }

    protected function addProvidersNode(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->ignoreExtraKeys()
            ->fixXmlConfig('factory', 'factories')
            ->children();

        foreach ($this->providers as $provider) {
            $factory = isset($this->factories[$provider]) ? $this->factories[$provider] : null;
            if ($factory === null) {
                throw new \LogicException(sprintf('No factory found for the provider "%s"', $provider));
            }

            $factoryNode = $rootNode->children()->arrayNode($provider)->isRequired();
            $factory->addConfiguration($factoryNode);
        }

        $rootNode->end();

        return $rootNode;
    }
}
