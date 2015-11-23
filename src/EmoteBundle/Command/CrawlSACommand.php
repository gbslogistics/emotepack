<?php

namespace GbsLogistics\Emotes\EmoteBundle\Command;


use Doctrine\ORM\EntityRepository;
use GbsLogistics\Emotes\EmoteBundle\Entity\Emote;
use GbsLogistics\Emotes\EmoteBundle\Entity\TextCode;
use GbsLogistics\Emotes\EmoteBundle\Model\RemoteEmote;
use GbsLogistics\Emotes\EmoteBundle\SAEmoteCrawler;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CrawlSACommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('emotes:crawl_sa')
            ->setDescription('Crawls forums.somethingawful.com for new emotes');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = $this->getLoggerCallback($output);
        /** @var SAEmoteCrawler $crawler */
        $crawler = $this->getContainer()->get('gbslogistics.emotes.emote_bundle.emote_client');
        /** @var EntityRepository $repository */
        $repository = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository(TextCode::class);

        $logger('Crawling forums.somethingawful.com now.');
        $saEmotes = $crawler->crawl();
        $logger(sprintf('Found %s emote(s).', count($saEmotes)));

        $existingEmotes = $repository->findAll();

        $logger(sprintf('Found %s existing emote codes.', count($existingEmotes)));
        /** @var RemoteEmote[] $saEmoteDictionary */
        $saEmoteDictionary = array_reduce($saEmotes, function ($result, RemoteEmote $item) {
            $result[$item->getName()] = $item;
            return $result;
        }, []);

        $existingEmotes = array_map(function (TextCode $item) {
            return $item->getCode();
        }, $existingEmotes);

        $newCodes = array_diff(array_keys($saEmoteDictionary), $existingEmotes);
        $logger(sprintf('Found %s new code(s): %s', count($newCodes), join(', ', $newCodes)));

        if (count($newCodes) > 0) {
            $dataStorage = $this->getContainer()->get('gbslogistics.emotes.emote_bundle.data_storage');
            $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
            $targetDirectory = $dataStorage->getSourceDirectory();

            foreach ($newCodes as $key) {
                $remoteEmote = $saEmoteDictionary[$key];
                $imageUrl = $remoteEmote->getImageUrl();

                // Retrieve emote image
                $path = parse_url($imageUrl, PHP_URL_PATH);
                $filename = basename($path);
                $destinationPath = $targetDirectory . DIRECTORY_SEPARATOR . $filename;

                $logger("Downloading $imageUrl to $destinationPath");
                file_put_contents($destinationPath, file_get_contents($imageUrl));

                // Store metadata
                $emote = new Emote();
                $textCode = new TextCode($emote, $remoteEmote->getName());
                $emote->setPath($filename);

                $entityManager->persist($emote);
                $entityManager->persist($textCode);
            }

            $entityManager->flush();

            // TODO: Rebuild all distributions
            // TODO: Rebuild front page
        }
    }

    private function getLoggerCallback(OutputInterface $output)
    {
        if ($output->getVerbosity() > OutputInterface::VERBOSITY_NORMAL) {
            return function ($message) use ($output) {
                $output->writeln($message);
            };
        }

        return function ($message) { ; };
    }
}