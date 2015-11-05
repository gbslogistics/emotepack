<?php

namespace GbsLogistics\Emotes;


use Doctrine\ORM\EntityManager;

/**
 * Reads an existing Pidgin emote package and extracts the emotes within, populating metadata to the database.
 * Class DatabasePopulator
 * @package GbsLogistics\Emotes
 */
class DatabasePopulator
{
    /** @var EntityManager */
    private $entityManager;

    function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
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
        $foundEmotes = false;
        while (false !== $line = fgets($themeHandle) && false === $foundEmotes) {
            $line = trim($line);
            if ('[default]' === $line) {
                $foundEmotes = true;
            }
        }

        if (false === $foundEmotes) {
            throw new \RuntimeException(sprintf('Could not find emote information in "%s".', $themeFile));
        }

        while (false !== $line = fgets($themeHandle)) {
            $line = trim($line);

            if (preg_match('/(?:! )?(\S+)\s+(.+)/', $line, $matches)) {
                $file = $matches[1];
                $emoteCodes = preg_split('/\s+/', $matches[2]);

                // TODO: Copy image to distribution source directory
                // TODO: Persist metadata to database
            }
        }

        $this->entityManager->flush();
    }
}