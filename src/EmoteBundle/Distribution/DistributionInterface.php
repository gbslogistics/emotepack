<?php

namespace GbsLogistics\Emotes\EmoteBundle\Distribution;


use GbsLogistics\Emotes\EmoteBundle\Model\DistributionArtifact;

interface DistributionInterface
{
    /**
     * Creates the distribution artifact.
     *
     * @param \Generator $emoteGenerator Contains a generator which will yield objects
     *     of type GbsLogistics\Emotes\EmoteBundle\Entity\Emote .
     * @return DistributionArtifact
     */
    public function generateArtifact(\Generator $emoteGenerator);

    /**
     * @param string $namespace
     */
    public function setNamespace($namespace);
}