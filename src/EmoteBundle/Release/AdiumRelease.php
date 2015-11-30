<?php

namespace GbsLogistics\Emotes\EmoteBundle\Release;

use GbsLogistics\Emotes\EmoteBundle\DataStorage;
use GbsLogistics\Emotes\EmoteBundle\Entity\Emote;
use GbsLogistics\Emotes\EmoteBundle\Entity\TextCode;
use GbsLogistics\Emotes\EmoteBundle\Model\ReleaseArtifact;

class AdiumRelease extends AbstractRelease
{
    /** @var DataStorage */
    private $dataStorage;

    function __construct(DataStorage $dataStorage)
    {
        $this->dataStorage = $dataStorage;
    }

    protected function getPlistEntry(Emote $emote)
    {
        $equivalents = '';
        
        foreach($emote->getTextCodes() as $textCode)
        {
            $equivalents .= ('<string>' . $textCode->getCode() . '</string>');
        }
        
        return sprintf(<<<PLISTENTRY
<key>%s</key>
<dict>
<key>Equivalents</key>
<array>%s</array>
<key>Name</key>
<string>%s</string>
</dict>
PLISTENTRY
,
$emote->getPath(),
$equivalents,
$emote->getPath()
);
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
        $zipDir = 'GoonfleetEmotes.AdiumEmoticonSet';
        $outputFilename = tempnam(sys_get_temp_dir(), $this->getNamespace());

        $zip = new \ZipArchive();
        if (!$zip->open($outputFilename)) {
            throw new \RuntimeException(sprintf('Can\'t open file %s for writing', $outputFilename));
        }

        $zip->addEmptyDir($zipDir);
        
        $plist = <<<PLISTHEADER
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<dict>
<key>AdiumSetVersion</key>
<integer>1</integer>
<key>Emoticons</key>
<dict>
PLISTHEADER;

        foreach($emoteGenerator as $emote) {
            $plist .= $this->getPlistEntry($emote);
            $zip->addFile($this->dataStorage->getImageSourcePath($emote->getPath()), $zipDir . '/' . $emote->getPath());
        }
        
        $plist .= '</dict></dict></plist>';
        
        $zip->addFromString($zipDir . '/Emoticons.plist', $plist);
        $zip->close();
        
        $artifact = new ReleaseArtifact();
        $artifact->setNamespace($this->getNamespace());
        $artifact->setPath($outputFilename);
        $artifact->setName('Adium');
        return $artifact;
    }
    
    public function getNamespace()
    {
        return 'adium';
    }
}
