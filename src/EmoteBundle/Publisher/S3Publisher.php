<?php

namespace GbsLogistics\Emotes\EmoteBundle\Publisher;


use GbsLogistics\Emotes\EmoteBundle\Model\PublishedRelease;
use GbsLogistics\Emotes\EmoteBundle\Model\ReleaseArtifact;
use GbsLogistics\Emotes\S3Client;

class S3Publisher implements PublisherInterface
{
    private $s3Client;

    function __construct(S3Client $s3Client)
    {
        $this->s3Client = $s3Client;
    }

    /**
     * Publishes a release to a publicly available destination.
     *
     * @param ReleaseArtifact $artifact
     * @return PublishedRelease
     */
    public function publish(ReleaseArtifact $artifact)
    {
        $results = $this->s3Client->putObject($artifact->getNamespace() . '.zip', $artifact->getPath());

        return new PublishedRelease($artifact->getName(), $results->get('ObjectURL'));
    }
}