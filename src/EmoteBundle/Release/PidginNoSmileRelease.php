<?php

namespace GbsLogistics\Emotes\EmoteBundle\Release;


use GbsLogistics\Emotes\EmoteBundle\Entity\Emote;

class PidginNoSmileRelease extends PidginRelease
{
    protected function generateEmoteEntry(Emote $emote)
    {
        return '! ' . parent::generateEmoteEntry($emote);
    }

    protected function generateHeader()
    {
        $header = parent::generateHeader();
        $header->setName($header->getName() . ', No-Smile Version');
        $header->setIcon('smugjones.001.gif');

        return $header;
    }

    protected function getName()
    {
        return 'Pidgin, No Smile Menu';
    }
}