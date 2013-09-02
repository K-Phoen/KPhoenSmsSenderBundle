<?php

namespace KPhoen\SmsSenderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class FactoriesConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('k_phoen_sms_sender');

        $this->addProviderFactoriesNode($rootNode);

        return $treeBuilder;
    }

    protected function addProviderFactoriesNode(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->ignoreExtraKeys()
            ->fixXmlConfig('factory', 'factories')
            ->children()
                ->arrayNode('factories')
                    ->prototype('scalar')->end()
                ->end()
            ->end();

        return $rootNode;
    }
}
