<?php

namespace GbsLogistics\Emotes\EmoteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="history")
 * Class History
 * @package GbsLogistics\Emotes\EmoteBundle\Entity
 */
class History
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @var \DateTime
     */
    private $dateCreated;

    /**
     * @ORM\ManyToMany(targetEntity="Emote")
     * @ORM\JoinTable(name="history_emotes",
     *      joinColumns={@ORM\JoinColumn(name="history_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="emote_id", referencedColumnName="id")}
     * )
     * @var ArrayCollection|Emote[]
     */
    private $emotes;

    function __construct()
    {
        $this->dateCreated = new \DateTime();
        $this->emotes = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|Emote[]
     */
    public function getEmotes()
    {
        return $this->emotes;
    }

    /**
     * @param ArrayCollection|Emote[] $emotes
     */
    public function setEmotes($emotes)
    {
        $this->emotes = $emotes;
    }


    public function addEmote(Emote $emote)
    {
        $this->emotes->add($emote);
    }
}