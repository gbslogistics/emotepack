<?php

namespace GbsLogistics\Emotes\EmoteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Emote
 * @ORM\Entity
 * @ORM\Table(name="emotes")
 * @package GbsLogistics\Emotes\Entity
 */
class Emote
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $path;

    /**
     * @ORM\OneToMany(targetEntity="TextCode", mappedBy="emote")
     * @var TextCode[]
     */
    private $textCodes;

    function __construct()
    {
        $this->textCodes = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getTextCodes()
    {
        return $this->textCodes;
    }

    /**
     * @param mixed $textCodes
     */
    public function setTextCodes($textCodes)
    {
        $this->textCodes = $textCodes;
    }

    /**
     * @return \string[]
     * @throws \Exception
     */
    public function getTextCodesAsArray()
    {
        return array_map(function (TextCode $code) {
            return $code->getCode();
        }, $this->getTextCodes()->toArray());
    }

}