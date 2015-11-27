<?php

namespace GbsLogistics\Emotes\EmoteBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BuildWebsiteCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('emotes:build_website')
            ->setDescription('Creates new distributions from emote data');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $publishedReleases = $this->getContainer()->get('gbslogistics.emotes.emote_bundle.release_compiler')->compile();
        $this->getContainer()->get('gbslogistics.emotes.emote_bundle.website_assembler')->assemble($publishedReleases);
    }

}