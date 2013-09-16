<?php

namespace KPhoen\SmsSenderBundle;

use KPhoen\SmsSenderBundle\DependencyInjection\Compiler\LoggerCompilerPass;
use KPhoen\SmsSenderBundle\DependencyInjection\Compiler\PoolCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class KPhoenSmsSenderBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new PoolCompilerPass());
        $container->addCompilerPass(new LoggerCompilerPass());
    }
}
