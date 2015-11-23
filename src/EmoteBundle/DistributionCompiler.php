<?php

namespace GbsLogistics\Emotes\EmoteBundle;


use Doctrine\ORM\EntityRepository;
use GbsLogistics\Emotes\EmoteBundle\Distribution\DistributionInterface;

class DistributionCompiler
{
    /** @var array */
    private $distributions;

    /** @var EntityRepository */
    private $entityRepository;

    function __construct(EntityRepository $entityRepository)
    {
        $this->distributions = [];
        $this->entityRepository = $entityRepository;
    }

    public function addDistribution(DistributionInterface $distribution, $namespace)
    {
        $distribution->setNamespace($namespace);
        $this->distributions[] = $distribution;
    }

    public function compile()
    {

    }

    private function getEmotesGenerator()
    {

    }
}