<?php

namespace App;

use App\DependencyInjection\Compiler\AdminControllerCompilerPass;
use Knp\RadBundle\AppBundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class App extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AdminControllerCompilerPass());
    }
}
