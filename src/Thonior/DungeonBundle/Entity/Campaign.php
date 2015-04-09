<?php

namespace Thonior\DungeonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Campaign
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Campaign
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="mastering")
     * @ORM\JoinColumn(name="master_id", referencedColumnName="id")
     */
    private $master;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="campaigns")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $players;

    /**
     * @var string
     *
     * @ORM\Column(name="heros", type="string", length=255)
     */
    private $heroes;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Campaign
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set master
     *
     * @param string $master
     * @return Campaign
     */
    public function setMaster($master)
    {
        $this->master = $master;

        return $this;
    }

    /**
     * Get master
     *
     * @return string 
     */
    public function getMaster()
    {
        return $this->master;
    }

    /**
     * Set players
     *
     * @param string $players
     * @return Campaign
     */
    public function setPlayers($players)
    {
        $this->players = $players;

        return $this;
    }

    /**
     * Get players
     *
     * @return string 
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * Set heros
     *
     * @param string $heros
     * @return Campaign
     */
    public function setHeroes($heroes)
    {
        $this->heroes = $heroes;

        return $this;
    }

    /**
     * Get heros
     *
     * @return string 
     */
    public function getHeroes()
    {
        return $this->heroes;
    }
}
