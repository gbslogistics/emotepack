<?php

namespace GbsLogistics\Emotes\EmoteBundle\ArtifactDisposal;


use GbsLogistics\Emotes\EmoteBundle\Model\ReleaseArtifact;

class UnlinkArtifactDisposal implements ArtifactDisposalInterface
{
    /**
     * Disposes of a distribution artifact.
     *
     * @param ReleaseArtifact $artifact
     * @return void
     */
    public function dispose(ReleaseArtifact $artifact)
    {
        unlink($artifact->getPath());
    }
}