<?php
declare(strict_types=1);

namespace Shared\Infrastructure\Framework\DependencyInjection;

use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AliasingServicesForTestCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definitions = $container->getDefinitions();
        foreach ($definitions as $definition) {
            $class = $definition->getClass();
            if (is_null($class)) {
                continue;
            }

            if (strpos($class, 'Shared\\') !== 0 && strpos($class, 'Todo\\') !== 0) {
                continue;
            }

            $container->setAlias("Aliased\\" . $class, new Alias($class, true));
        }
    }
}
