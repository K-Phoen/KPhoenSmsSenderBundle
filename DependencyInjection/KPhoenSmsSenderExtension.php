<?php

namespace KPhoen\SmsSenderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

use KPhoen\SmsSenderBundle\DependencyInjection\Factory\ProviderFactoryInterface;

class KPhoenSmsSenderExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();

        // first assemble the adapter factories
        $factoriesConfig = new FactoriesConfiguration();
        $config = $processor->processConfiguration($factoriesConfig, $configs);
        $factories = $this->createProviderFactories($config, $container);

        // then handle to main configuration part
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // then check the providers configuration
        $providersConfig = new ProvidersConfiguration($config['providers'], $factories);
        $providersConfig = $this->processConfiguration($providersConfig, $configs);

        // and now, create the providers required by the configuration
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        $loader->load('providers.xml');

        // start fixing providers definitions
        $definition = $container->getDefinition('sms.sender');
        foreach ($config['providers'] as $provider) {
            $id = $this->createProvider($provider, $factories, $container, $providersConfig);

            // also register it to the main sms.sender service
            $definition->addMethodCall('registerProvider', array(new Reference($id)));
        }

        // fix the sms.http_adapter definition to point to the right adapter
        $container->setAlias('sms.http_adapter', sprintf('sms.http_adapter.%s', $config['http_adapter']));
        $container->getAlias('sms.http_adapter')->setPublic(false);
    }

    protected function createProvider($name, array $factories, ContainerBuilder $container, array $providersConfig)
    {
        $factory = isset($factories[$name]) ? $factories[$name] : null;
        if ($factory === null) {
            throw new \LogicException(sprintf('No factory found for the provider "%s"', $name));
        }

        $factory->create($container, 'sms.provider.'.$name, $providersConfig[$name]);

        return 'sms.provider.'.$name;
    }

    /**
     * Creates the provider factories
     *
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function createProviderFactories($config, ContainerBuilder $container)
    {
        // load bundled adapter factories
        $tempContainer = new ContainerBuilder();
        $parameterBag = $container->getParameterBag();
        $loader = new XmlFileLoader($tempContainer, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('provider_factories.xml');

        // load user-created adapter factories
        foreach ($config['factories'] as $factory) {
            $loader->load($parameterBag->resolveValue($factory));
        }

        $services = $tempContainer->findTaggedServiceIds('sms.provider.factory');
        $factories = array();
        foreach (array_keys($services) as $id) {
            $factory = $tempContainer->get($id);
            $factories[str_replace('-', '_', $factory->getKey())] = $factory;
        }

        return $factories;
    }
}
