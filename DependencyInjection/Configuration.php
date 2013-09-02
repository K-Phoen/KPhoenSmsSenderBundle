<?php

namespace KPhoen\SmsSenderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    protected $factories = array();

    public function __construct(array $factories = array())
    {
        $this->factories = $factories;
    }

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('k_phoen_sms_sender');
        $rootNode->ignoreExtraKeys();

        $this->addHttpAdapterNode($rootNode);
        $this->addProvidersNode($rootNode);

        return $treeBuilder;
    }

    protected function addProvidersNode(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->fixXmlConfig('provider')
            ->children()
                ->arrayNode('providers')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->prototype('scalar')->end()
                ->end()
            ->end();

        foreach ($this->factories as $name => $factory) {
            $factoryNode = $rootNode->children()->arrayNode($name)->canBeUnset();

            $factory->addConfiguration($factoryNode);
        }

        return $rootNode;
    }

    protected function addHttpAdapterNode(ArrayNodeDefinition $rootNode)
    {
        $supportedHttpAdapters = array('curl', 'buzz');

        $rootNode
            ->children()
                ->scalarNode('http_adapter')
                ->defaultValue('curl')
                ->validate()
                    ->ifNotInArray($supportedHttpAdapters)
                    ->thenInvalid('The http_adapter %s is not supported. Please choose one of ' . implode(', ', $supportedHttpAdapters))
                ->end()
            ->end();

        return $rootNode;
    }
}
