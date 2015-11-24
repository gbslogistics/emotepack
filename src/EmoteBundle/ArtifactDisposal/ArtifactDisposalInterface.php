<?php

namespace GbsLogistics\Emotes\EmoteBundle\ArtifactDisposal;


use GbsLogistics\Emotes\EmoteBundle\Model\DistributionArtifact;

interface ArtifactDisposalInterface
{
    /**
     * Disposes of a distribution artifact.
     *
     * @param DistributionArtifact $artifact
     * @return void
     */
    public function dispose(DistributionArtifact $artifact);
}