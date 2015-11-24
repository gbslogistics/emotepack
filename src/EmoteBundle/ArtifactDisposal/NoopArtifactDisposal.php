<?php

namespace GbsLogistics\Emotes\EmoteBundle\ArtifactDisposal;


use GbsLogistics\Emotes\EmoteBundle\Model\DistributionArtifact;

/**
 * Does nothing to dispose of distribution artifacts.
 *
 * Class NoopArtifactDisposal
 * @package GbsLogistics\Emotes\EmoteBundle\ArtifactDisposal
 */
class NoopArtifactDisposal implements ArtifactDisposalInterface
{

    /**
     * Disposes of a distribution artifact.
     *
     * @param DistributionArtifact $artifact
     * @return void
     */
    public function dispose(DistributionArtifact $artifact)
    {
        ;
    }
}