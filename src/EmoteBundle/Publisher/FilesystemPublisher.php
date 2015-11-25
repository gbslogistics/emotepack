<?php

namespace GbsLogistics\Emotes\EmoteBundle\Publisher;


use GbsLogistics\Emotes\EmoteBundle\DataStorage;
use GbsLogistics\Emotes\EmoteBundle\Model\DistributionArtifact;

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

    public function publish(DistributionArtifact $artifact)
    {
        copy($artifact->getPath(), $this->dataStorage->getDistDirectory($artifact->getNamespace()) . DIRECTORY_SEPARATOR . date('YmdHis') . '.zip');
    }
}