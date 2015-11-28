<?php

namespace GbsLogistics\Emotes\EmoteBundle\Delivery;


interface DeliveryInterface
{
    /**
     * Publishes the new site to the internet.
     *
     * @param string $indexHTML
     */
    public function deliver($indexHTML);
}