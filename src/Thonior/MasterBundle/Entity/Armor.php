<?php

namespace Thonior\MasterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Armor
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Thonior\DungeonBundle\Entity\ArmorRepository")
 */
class Armor extends Item
{

    /**
     * @var integer
     *
     * @ORM\Column(name="CA", type="integer")
     */
    private $CA;

    /**
     * @var integer
     *
     * @ORM\Column(name="penalty", type="integer")
     */
    private $penalty;

    /**
     * @var string
     * Choose between: Chest, head, foot, legs, belt, arms, hands
     * @ORM\Column(name="position", type="string", length=255)
     */
    private $position;

    /**
     * Set cA
     *
     * @param integer $cA
     * @return Armor
     */
    public function setCA($CA)
    {
        $this->CA = $CA;

        return $this;
    }

    /**
     * Get cA
     *
     * @return integer 
     */
    public function getCA()
    {
        return $this->CA;
    }

    /**
     * Set penalty
     *
     * @param integer $penalty
     * @return Armor
     */
    public function setPenalty($penalty)
    {
        $this->penalty = $penalty;

        return $this;
    }

    /**
     * Get penalty
     *
     * @return integer 
     */
    public function getPenalty()
    {
        return $this->penalty;
    }

    /**
     * Set position
     *
     * @param string $position
     * @return Armor
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }
    
    private $type = 'armor';
    
    public function getType(){
        return $this->type;
    }
    
    public function setType($type){
        $this->type = $type;
        return $this;
    }
}
