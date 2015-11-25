<?php

namespace GbsLogistics\Emotes\EmoteBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateDistributionsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('emotes:generate_distribution')
            ->setDescription('Creates new distributions from emote data');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $distributionCompiler = $this->getContainer()->get('gbslogistics.emotes.emote_bundle.distribution_compiler');
        $distributionCompiler->compile();
    }

}