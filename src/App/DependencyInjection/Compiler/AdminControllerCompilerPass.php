<?php
namespace App\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AdminControllerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds('sonata.admin') as $id => $tags) {
            $definition = $container->getDefinition($id);
            $arguments = $definition->getArguments();
            if (false !== strpos($arguments[2], 'Sonata')) {
                $definition->replaceArgument(2, $container->getParameter('app.controller.admin.class'));
            }
        }
    }
}
