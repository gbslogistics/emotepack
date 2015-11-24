<?php

namespace GbsLogistics\Emotes\EmoteBundle\Publisher;


use GbsLogistics\Emotes\EmoteBundle\Model\DistributionArtifact;

interface PublisherInterface
{
    public function publish(DistributionArtifact $artifact);
}