<?php

namespace GbsLogistics\Emotes\EmoteBundle\ArtifactDisposal;


use GbsLogistics\Emotes\EmoteBundle\Model\ReleaseArtifact;

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
     * @param ReleaseArtifact $artifact
     * @return void
     */
    public function dispose(ReleaseArtifact $artifact)
    {
        ;
    }
}