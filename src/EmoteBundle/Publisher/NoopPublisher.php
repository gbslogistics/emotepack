<?php

namespace GbsLogistics\Emotes\EmoteBundle\Publisher;


use GbsLogistics\Emotes\EmoteBundle\Model\ReleaseArtifact;

class NoopPublisher implements PublisherInterface
{
    public function publish(ReleaseArtifact $artifact)
    {
        ;
    }
}