<?php

namespace GbsLogistics\Emotes\EmoteBundle\DependencyInjection;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class EmoteCompilerPass implements CompilerPassInterface
{
    const DISPOSAL_SERVICE_PARAMETER = 'gbslogistics.emotes.disposal_service';
    const PUBLISHER_SERVICE_PARAMETER = 'gbslogistics.emotes.publisher_service';
    const DISTRIBUTION_SERVICE_PARAMETER = 'gbslogistics.emotes.distribution_service';

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition('gbslogistics.emotes.emote_bundle.release_compiler')) {
            $releaseCompilerDefinition = $container->getDefinition('gbslogistics.emotes.emote_bundle.release_compiler');
            $taggedServices = $container->findTaggedServiceIds('gbslogistics.emote_release');

            foreach ($taggedServices as $id => $tags) {
                foreach ($tags as $attributes) {
                    $releaseCompilerDefinition->addMethodCall('addRelease', [ new Reference($id), $attributes['namespace'] ]);
                }
            }

            if (!$container->hasParameter(self::DISPOSAL_SERVICE_PARAMETER)) {
                throw new \RuntimeException(sprintf('Expected to find a parameter named "%s", but none was provided.', self::DISPOSAL_SERVICE_PARAMETER));
            }

            if (!$container->hasParameter(self::PUBLISHER_SERVICE_PARAMETER)) {
                throw new \RuntimeException(sprintf('Expected to find a parameter named "%s", but none was provided.', self::PUBLISHER_SERVICE_PARAMETER));
            }

            $disposalService = $container->getParameter(self::DISPOSAL_SERVICE_PARAMETER);
            $publisherService = $container->getParameter(self::PUBLISHER_SERVICE_PARAMETER);
            if (!$container->hasDefinition($disposalService)) {
                throw new \RuntimeException(sprintf('Could not find service "%s" for use as the disposal service.', $disposalService));
            }
            if (!$container->hasDefinition($publisherService)) {
                throw new \RuntimeException(sprintf('Could not find service "%s" for use as the publisher service.', $publisherService));
            }

            $releaseCompilerDefinition->addMethodCall('setDisposal', [ $container->getDefinition($disposalService) ]);
            $releaseCompilerDefinition->addMethodCall('setPublisher', [ $container->getDefinition($publisherService) ]);
        }

        if ($container->hasDefinition('gbslogistics.emotes.emote_bundle.website_assembler')) {
            $websiteAssemblerDefinition = $container->getDefinition('gbslogistics.emotes.emote_bundle.website_assembler');
            $distributionService = $container->getParameter(self::DISTRIBUTION_SERVICE_PARAMETER);

            if (!$container->hasDefinition($distributionService)) {
                throw new \RuntimeException(sprintf('Could not find service "%s" for use as the distribution service.', $distributionService));
            }

            $websiteAssemblerDefinition->addMethodCall('setDistribution', [ $container->getDefinition($distributionService) ]);
        }
    }
}