<?php
namespace GbsLogistics\Emotes\Model;

class RemoteEmote
{
    /** @var string */
    private $name;

    /** @var string */
    private $imageUrl;

    function __construct($name, $imageUrl)
    {
        $this->name = $name;
        $this->imageUrl = $imageUrl;
    }
}