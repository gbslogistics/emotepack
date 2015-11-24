<?php

namespace GbsLogistics\Emotes\EmoteBundle\Publisher;


use GbsLogistics\Emotes\EmoteBundle\Model\DistributionArtifact;

class NoopPublisher implements PublisherInterface
{
    public function publish(DistributionArtifact $artifact)
    {
        ;
    }
}