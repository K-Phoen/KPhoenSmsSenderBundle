<?php

namespace KPhoen\SmsSenderBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class LoggerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('sms.sender') || false === $container->getParameter('kernel.debug')) {
            return;
        }

        $loggedDefinition = new Definition($container->getParameter('sms.logged_sender.class'), array(
            $container->getDefinition('sms.sender'),
            new Reference('sms.sender.logger'),
        ));

        $container->setDefinition('sms.sender', $loggedDefinition);
    }
}
