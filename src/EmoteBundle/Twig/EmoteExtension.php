<?php

namespace GbsLogistics\Emotes\EmoteBundle\Twig;


use GbsLogistics\Emotes\EmoteBundle\Entity\History;

class EmoteExtension extends \Twig_Extension
{

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        /** @noinspection SpellCheckingInspection */
        return 'emotebundle_extension';
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('historyEmotes', [ $this, 'historyEmotesFilter' ])
        ];
    }

    public function historyEmotesFilter($history)
    {
        if (!is_object($history) || !($history instanceof History)) {
            throw new \InvalidArgumentException('Argument to historyEmotes must be an object of type ' . History::class . '.');
        }

        $codes = [];
        foreach ($history->getEmotes() as $emote) {
            foreach ($emote->getTextCodesAsArray() as $code) {
                $codes[] = $code;
            }
        }

        return implode(', ', $codes);
    }
}