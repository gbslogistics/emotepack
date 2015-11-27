<?php

namespace GbsLogistics\Emotes\EmoteBundle\Publisher;


use GbsLogistics\Emotes\EmoteBundle\Model\PublishedRelease;
use GbsLogistics\Emotes\EmoteBundle\Model\ReleaseArtifact;

interface PublisherInterface
{
    /**
     * Publishes a release to a publicly available destination.
     *
     * @param ReleaseArtifact $artifact
     * @return PublishedRelease
     */
    public function publish(ReleaseArtifact $artifact);
}