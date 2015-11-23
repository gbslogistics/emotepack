<?php

namespace GbsLogistics\Emotes\EmoteBundle;


use GbsLogistics\Emotes\EmoteBundle\DependencyInjection\EmoteCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EmotesBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new EmoteCompilerPass());
    }

}