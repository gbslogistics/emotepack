<?php

namespace GbsLogistics\Emotes\EmoteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class TextCode
 * @ORM\Entity
 * @ORM\Table(name="text_codes")
 * @package GbsLogistics\Emotes\Entity
 */
class TextCode
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Emote", inversedBy="textCodes")
     * @ORM\JoinColumn(name="emote_id", referencedColumnName="id")
     */
    private $emote;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $code;

    function __construct(Emote $emote, $code)
    {
        $this->emote = $emote;
        $this->code = $code;
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
     * @return Emote
     */
    public function getEmote()
    {
        return $this->emote;
    }

    /**
     * @param Emote $emote
     */
    public function setEmote($emote)
    {
        $this->emote = $emote;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }
}