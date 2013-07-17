<?php

namespace Totalcan\BravoregBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Totalcan\BravoregBundle\DependencyInjection\Security\Factory\BravoregFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TotalcanBravoregBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new BravoregFactory());
    }
}
