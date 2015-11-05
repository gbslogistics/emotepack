<?php

namespace GbsLogistics\Emotes\Entity;

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

    function __construct($emoteId, $code)
    {
        $this->emoteId = $emoteId;
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
     * @return int
     */
    public function getEmoteId()
    {
        return $this->emoteId;
    }

    /**
     * @param int $emoteId
     */
    public function setEmoteId($emoteId)
    {
        $this->emoteId = $emoteId;
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