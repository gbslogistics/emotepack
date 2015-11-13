<?php
namespace GbsLogistics\Emotes\EmoteBundle\Model;

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

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }
}