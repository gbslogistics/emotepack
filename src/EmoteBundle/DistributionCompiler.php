<?php

namespace GbsLogistics\Emotes\EmoteBundle;


use Doctrine\ORM\EntityRepository;
use GbsLogistics\Emotes\EmoteBundle\ArtifactDisposal\ArtifactDisposalInterface;
use GbsLogistics\Emotes\EmoteBundle\Distribution\AbstractDistribution;
use GbsLogistics\Emotes\EmoteBundle\Entity\Emote;
use GbsLogistics\Emotes\EmoteBundle\Publisher\PublisherInterface;

class DistributionCompiler
{
    /** @var AbstractDistribution[] */
    private $distributions;

    /** @var EntityRepository */
    private $entityRepository;

    /** @var PublisherInterface */
    private $publisher = null;

    /** @var ArtifactDisposalInterface */
    private $disposal = null;

    function __construct(EntityRepository $entityRepository)
    {
        $this->distributions = [];
        $this->entityRepository = $entityRepository;
    }

    public function addDistribution(AbstractDistribution $distribution, $namespace)
    {
        $distribution->setNamespace($namespace);
        $this->distributions[] = $distribution;
    }

    public function compile()
    {
        if (null === $this->publisher) {
            throw new \RuntimeException('A valid publisher object was not injected.');
        }

        if (null === $this->disposal) {
            throw new \RuntimeException('A valid disposal object was not injected.');
        }

        $entityRepository = $this->entityRepository;
        foreach ($this->distributions as $distribution) {
            $artifact = $distribution->generateArtifact($this->getEmoteGenerator());
            $this->publisher->publish($artifact);
            $this->disposal->dispose($artifact);
        }
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