<?php

namespace GbsLogistics\Emotes\EmoteBundle\Distribution;


use GbsLogistics\Emotes\EmoteBundle\Entity\Emote;

class PidginNoSmileDistribution extends PidginDistribution
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
}