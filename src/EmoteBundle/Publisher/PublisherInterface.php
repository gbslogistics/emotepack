<?php

namespace GbsLogistics\Emotes\EmoteBundle\Publisher;


use GbsLogistics\Emotes\EmoteBundle\Model\ReleaseArtifact;

interface PublisherInterface
{
    public function publish(ReleaseArtifact $artifact);
}