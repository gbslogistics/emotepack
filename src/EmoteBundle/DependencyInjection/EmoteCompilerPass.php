<?php

namespace GbsLogistics\Emotes\EmoteBundle\DependencyInjection;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class EmoteCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('gbslogistics.emotes.emote_bundle.distribution_compiler')) {
            return;
        }

        $definition = $container->getDefinition('gbslogistics.emotes.emote_bundle.distribution_compiler');
        $taggedServices = $container->findTaggedServiceIds('gbslogistics.emote_distribution');

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall('addDistribution', [ new Reference($id), $attributes['namespace'] ]);
            }
        }
    }
}