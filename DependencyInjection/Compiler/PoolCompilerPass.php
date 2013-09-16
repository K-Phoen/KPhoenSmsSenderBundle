<?php

namespace KPhoen\SmsSenderBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class PoolCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('sms.sender') || false === $container->hasAlias('sms.pool')) {
            return;
        }

        $delayedDefinition = new Definition($container->getParameter('sms.delayed_sender.class'), array(
            $container->getDefinition('sms.sender'),
            new Reference('sms.pool'),
        ));

        $container->setDefinition('sms.sender', $delayedDefinition);
    }
}
