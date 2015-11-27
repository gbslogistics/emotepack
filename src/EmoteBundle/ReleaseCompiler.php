<?php

namespace GbsLogistics\Emotes\EmoteBundle;


use Doctrine\ORM\EntityRepository;
use GbsLogistics\Emotes\EmoteBundle\ArtifactDisposal\ArtifactDisposalInterface;
use GbsLogistics\Emotes\EmoteBundle\Release\AbstractRelease;
use GbsLogistics\Emotes\EmoteBundle\Entity\Emote;
use GbsLogistics\Emotes\EmoteBundle\Model\PublishedRelease;
use GbsLogistics\Emotes\EmoteBundle\Publisher\PublisherInterface;

class ReleaseCompiler
{
    /** @var AbstractRelease[] */
    private $releases;

    /** @var EntityRepository */
    private $entityRepository;

    /** @var PublisherInterface */
    private $publisher = null;

    /** @var ArtifactDisposalInterface */
    private $disposal = null;

    function __construct(EntityRepository $entityRepository)
    {
        $this->releases = [];
        $this->entityRepository = $entityRepository;
    }

    public function addRelease(AbstractRelease $release, $namespace)
    {
        $release->setNamespace($namespace);
        $this->releases[] = $release;
    }

    /**
     * @return PublishedRelease[]
     */
    public function compile()
    {
        if (null === $this->publisher) {
            throw new \RuntimeException('A valid publisher object was not injected.');
        }

        if (null === $this->disposal) {
            throw new \RuntimeException('A valid disposal object was not injected.');
        }

        $publishedReleases = [];

        $entityRepository = $this->entityRepository;
        foreach ($this->releases as $release) {
            $artifact = $release->generateArtifact($this->getEmoteGenerator());
            $publishedRelease = $this->publisher->publish($artifact);
            $this->disposal->dispose($artifact);
            $publishedReleases[] = $publishedRelease;
        }

        return $publishedReleases;
    }

    /**
     * @return \Generator
     */
    private function getEmoteGenerator()
    {
        /** @var Emote[] $emotes */
        $emotes = $this->entityRepository->findAll();
        foreach ($emotes as $emote) {
            yield $emote;
        }
    }

    /**
     * @param PublisherInterface $publisher
     */
    public function setPublisher(PublisherInterface $publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * @param ArtifactDisposalInterface $disposal
     */
    public function setDisposal(ArtifactDisposalInterface $disposal)
    {
        $this->disposal = $disposal;
    }
}