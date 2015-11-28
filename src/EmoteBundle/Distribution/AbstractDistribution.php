<?php

namespace GbsLogistics\Emotes\EmoteBundle\Distribution;


use GbsLogistics\Emotes\EmoteBundle\Model\PublishedRelease;

abstract class AbstractDistribution
{
    /**
     * Releases the finished emote pack's website and release artifacts for
     * public consumption.
     *
     * @param string $indexHTML
     * @return void
     */
    public function publishDistribution($indexHTML)
    {
        if (!is_string($indexHTML)) {
            throw new \InvalidArgumentException('Second argument passed to publishDistribution must be a string.');
        }

        $this->distribute($indexHTML);
    }

    /**
     * @param string $indexHTML
     * @return void
     */
    abstract protected function distribute($indexHTML);
}