<?php

namespace GbsLogistics\Emotes\EmoteBundle\Release;


use GbsLogistics\Emotes\EmoteBundle\DataStorage;
use GbsLogistics\Emotes\EmoteBundle\Entity\Emote;
use GbsLogistics\Emotes\EmoteBundle\Entity\TextCode;
use GbsLogistics\Emotes\EmoteBundle\Model\ReleaseArtifact;
use GbsLogistics\Emotes\EmoteBundle\Model\PidginThemeHeader;

class PidginRelease extends AbstractRelease
{
    /** @var DataStorage */
    private $dataStorage;

    function __construct(DataStorage $dataStorage)
    {
        $this->dataStorage = $dataStorage;
    }

    /**
     * @param Emote $emote
     * @return string
     */
    protected function generateEmoteEntry(Emote $emote)
    {
        $entries = '';

        /** @var TextCode $textCode */
        foreach ($emote->getTextCodes() as $textCode) {
            $entries .= sprintf("%s %s\n", $emote->getPath(), $textCode->getCode());
        }

        return $entries;
    }

    /** @return PidginThemeHeader */
    protected function generateHeader()
    {
        return new PidginThemeHeader(
            'SA-GF Pack',
            sprintf('Last Updated: %s', date('F jS, Y')),
            'emot-smug.gif',
            'Querns'
        );
    }

    /**
     * @return string
     */
    protected function getName()
    {
        return 'Pidgin';
    }

    /**
     * Creates the distribution artifact.
     *
     * @param \Generator $emoteGenerator Contains a generator which will yield objects
     *     of type GbsLogistics\Emotes\EmoteBundle\Entity\Emote .
     * @return ReleaseArtifact
     */
    public function generateArtifact(\Generator $emoteGenerator)
    {
        $zipDir = $this->getNamespace();
        $outputFilename = tempnam(sys_get_temp_dir(), $this->getNamespace());

        $zip = new \ZipArchive();
        if (!$zip->open($outputFilename)) {
            throw new \RuntimeException(sprintf('Can\'t open file %s for writing', $outputFilename));
        }

        $zip->addEmptyDir($zipDir);

        $header = $this->generateHeader();
        $themeFile = sprintf(<<<EOTXT
Name=%s
Description=%s
Icon=%s
Author=%s

[default]

EOTXT
        ,
            $header->getName(),
            $header->getDescription(),
            $header->getIcon(),
            $header->getAuthor()
        );

        /** @var Emote $emote */
        foreach ($emoteGenerator as $emote) {
            $themeFile .= $this->generateEmoteEntry($emote);
            $zip->addFile($this->dataStorage->getImageSourcePath($emote->getPath()), $zipDir . '/' . $emote->getPath());
        }

        $zip->addFromString($zipDir . '/theme', $themeFile);
        $zip->close();

        $artifact = new ReleaseArtifact();
        $artifact->setNamespace($this->getNamespace());
        $artifact->setPath($outputFilename);
        $artifact->setName($this->getName());
        return $artifact;
    }
}