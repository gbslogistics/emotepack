<?php

namespace GbsLogistics\Emotes\EmoteBundle\Release;


use GbsLogistics\Emotes\EmoteBundle\Model\ReleaseArtifact;

abstract class AbstractRelease
{
    /**
     * @var string
     */
    protected $namespace;

    /**
     * Creates the distribution artifact.
     *
     * @param \Generator $emoteGenerator Contains a generator which will yield objects
     *     of type GbsLogistics\Emotes\EmoteBundle\Entity\Emote .
     * @return ReleaseArtifact
     */
    abstract public function generateArtifact(\Generator $emoteGenerator);

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }
}