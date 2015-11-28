<?php

namespace GbsLogistics\Emotes\EmoteBundle;


use Doctrine\ORM\EntityRepository;
use GbsLogistics\Emotes\EmoteBundle\Distribution\AbstractDistribution;
use GbsLogistics\Emotes\EmoteBundle\Entity\HistoryRepository;
use GbsLogistics\Emotes\EmoteBundle\Model\PublishedRelease;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\Templating\EngineInterface;

class WebsiteAssembler
{
    /** @var HistoryRepository */
    private $entityRepository;

    /** @var EngineInterface */
    private $templating;

    /** @var AbstractDistribution */
    private $distribution = null;

    function __construct(HistoryRepository $entityRepository, EngineInterface $templating)
    {
        $this->entityRepository = $entityRepository;
        $this->templating = $templating;
    }

    /**
     * @param AbstractDistribution $distribution
     */
    public function setDistribution(AbstractDistribution $distribution)
    {
        $this->distribution = $distribution;
    }

    public function assemble($releases)
    {
        if (!is_array($releases)) {
            throw new \InvalidArgumentException('Argument passed to assemble() must be an array.');
        }

        if (null === $this->distribution) {
            throw new \RuntimeException('No distribution was provided; check the parameters file.');
        }

        foreach ($releases as $release) {
            if (!($release instanceof PublishedRelease)) {
                throw new \InvalidArgumentException(sprintf(
                    'Argument passed to assemble() must be an array of PublishedRelease objects, but a %s was present.',
                    is_object($release) ? sprintf('object of type "%s"', get_class($release)) : gettype($release)
                ));
            }
        }

        $indexPage = $this->templating->render(':default:index.html.twig', [
            'releases' => $releases,
            'historyEntries' => $this->entityRepository->findAllOrderedByDateCreated(5)
        ]);

        $this->distribution->publishDistribution($indexPage);
    }
}