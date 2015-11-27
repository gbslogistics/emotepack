<?php

namespace GbsLogistics\Emotes\EmoteBundle;


use Doctrine\ORM\EntityRepository;
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

    function __construct(HistoryRepository $entityRepository, EngineInterface $templating)
    {
        $this->entityRepository = $entityRepository;
        $this->templating = $templating;
    }

    public function assemble($releases)
    {
        if (!is_array($releases)) {
            throw new \InvalidArgumentException('Argument passed to assemble() must be an array.');
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

        echo $indexPage;
    }
}