<?php
namespace GbsLogistics\Emotes\Command;

use GbsLogistics\Emotes\DatabasePopulator;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PopulateDatabaseCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('emotes:populate_database')
            ->setDescription('Reads info from pre-existing Pidgin emote pack')
            ->addArgument('path', InputArgument::REQUIRED, 'Path to the emote pack');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var DatabasePopulator $populator */
        $populator = $this->getContainer()->get('gbslogistics.emotes.database_populator');
        $populator->populateDatabase($input->getArgument('path'));
    }
}