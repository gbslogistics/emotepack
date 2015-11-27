<?php

namespace GbsLogistics\Emotes\EmoteBundle\Publisher;


use GbsLogistics\Emotes\EmoteBundle\DataStorage;
use GbsLogistics\Emotes\EmoteBundle\Model\PublishedRelease;
use GbsLogistics\Emotes\EmoteBundle\Model\ReleaseArtifact;

class FilesystemPublisher implements PublisherInterface
{
    /**
     * @var DataStorage
     */
    private $dataStorage;

    function __construct(DataStorage $dataStorage)
    {
        $this->dataStorage = $dataStorage;
    }

    /**
     * @param ReleaseArtifact $artifact
     * @return PublishedRelease
     */
    public function publish(ReleaseArtifact $artifact)
    {
        $releaseFilename = $this->dataStorage->getDistDirectory($artifact->getNamespace()) . DIRECTORY_SEPARATOR . date('YmdHis') . '.zip';
        copy($artifact->getPath(), $releaseFilename);

        return new PublishedRelease($artifact->getName(), realpath($releaseFilename));
    }
}