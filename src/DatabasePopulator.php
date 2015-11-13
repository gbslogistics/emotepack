<?php

namespace GbsLogistics\Emotes;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use GbsLogistics\Emotes\Entity\Emote;
use GbsLogistics\Emotes\Entity\TextCode;

/**
 * Reads an existing Pidgin emote package and extracts the emotes within, populating metadata to the database.
 * Class DatabasePopulator
 * @package GbsLogistics\Emotes
 */
class DatabasePopulator
{
    /** @var EntityManager */
    private $entityManager;

    /** @var DataStorage */
    private $dataStorage;

    /** @var EntityRepository */
    private $emoteRepository;

    function __construct(EntityManager $entityManager, DataStorage $dataStorage)
    {
        $this->entityManager = $entityManager;
        $this->dataStorage = $dataStorage;
        $this->emoteRepository = $this->entityManager->getRepository(Emote::class);
    }

    /**
     * @param string $directoryPath The path to the directory containing all of
     *     the emote images and the pidgin "theme" file.
     */
    public function populateDatabase($directoryPath)
    {
        $themeFile = $directoryPath . DIRECTORY_SEPARATOR . 'theme';

        if (!is_file($themeFile)) {
            throw new \InvalidArgumentException(sprintf('Could not locate "%s".', $themeFile));
        }

        if (false === $themeHandle = fopen($themeFile, 'r')) {
            throw new \InvalidArgumentException(sprintf('Could not open "%s".', $themeFile));
        }

        // Seek through the theme until we find where the emotes are located.
        while (false !== $line = fgets($themeHandle)) {
            $line = trim($line);
            if ('[default]' === $line) {
                break;
            }
        }

        if (feof($themeHandle)) {
            throw new \RuntimeException(sprintf('Could not find emote information in "%s".', $themeFile));
        }

        while (false !== $line = fgets($themeHandle)) {
            $line = trim($line);

            if (preg_match('/(?:! )?(\S+)\s+(.+)/', $line, $matches)) {
                $file = $matches[1];
                $emoteCodes = preg_split('/\s+/', $matches[2]);
                $sourcePath = $directoryPath . DIRECTORY_SEPARATOR . $file;
                $destinationPath = $this->dataStorage->getImageSourcePath($file);

                $emote = $this->emoteRepository->findOneBy([ 'path' => $file ]);
                if (null === $emote) {
                    $emote = new Emote();
                    $emote->setPath($file);

                    if (null === $destinationPath) {
                        $this->dataStorage->copyImageToSource($sourcePath);
                    }

                    $this->entityManager->persist($emote);
                    $this->entityManager->flush($emote);
                }

                $newCodes = array_diff($emoteCodes, $emote->getTextCodesAsArray());
                foreach ($newCodes as $code) {
                    $textCode = new TextCode($emote, $code);
                    $this->entityManager->persist($textCode);
                    $this->entityManager->flush($textCode);
                }
            }
        }

        $this->entityManager->flush();
    }
}