<?php

namespace GbsLogistics\Emotes\EmoteBundle\Distribution;


class NoopDistribution extends AbstractDistribution
{

    /**
     * @param string $indexHTML
     * @return void
     */
    protected function distribute($indexHTML)
    {
        ;
    }
}