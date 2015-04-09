<?php

namespace Thonior\MasterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Weapon
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Thonior\DungeonBundle\Entity\WeaponRepository")
 */
class Weapon extends Item
{

    /**
     * @var integer
     *
     * @ORM\Column(name="damage", type="integer")
     */
    private $damage;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="damage_type", type="string", length=255)
     */
    private $damageType;

    /**
     * @var string
     *
     * @ORM\Column(name="crit_chance", type="string", length=255)
     */
    private $critChance;

    /**
     * @var integer
     *
     * @ORM\Column(name="crit_bonus", type="integer")
     */
    private $critBonus;

    /**
     * @var integer
     *
     * @ORM\Column(name="bonus", type="integer",nullable=true)
     */
    private $bonus;

    /**
     * @var string
     *
     * @ORM\Column(name="bonus_type", type="string", length=255,nullable=true)
     */
    private $bonusType;

    /**
     * Set damage
     *
     * @param integer $damage
     * @return Weapon
     */
    public function setDamage($damage)
    {
        $this->damage = $damage;

        return $this;
    }

    /**
     * Get damage
     *
     * @return integer 
     */
    public function getDamage()
    {
        return $this->damage;
    }

    /**
     * Set critChance
     *
     * @param string $critChance
     * @return Weapon
     */
    public function setCritChance($critChance)
    {
        $this->critChance = $critChance;

        return $this;
    }

    /**
     * Get critChance
     *
     * @return string 
     */
    public function getCritChance()
    {
        return $this->critChance;
    }

    /**
     * Set critBonus
     *
     * @param integer $critBonus
     * @return Weapon
     */
    public function setCritBonus($critBonus)
    {
        $this->critBonus = $critBonus;

        return $this;
    }

    /**
     * Get critBonus
     *
     * @return integer 
     */
    public function getCritBonus()
    {
        return $this->critBonus;
    }

    /**
     * Set bonus
     *
     * @param integer $bonus
     * @return Weapon
     */
    public function setBonus($bonus)
    {
        $this->bonus = $bonus;

        return $this;
    }

    /**
     * Get bonus
     *
     * @return integer 
     */
    public function getBonus()
    {
        return $this->bonus;
    }

    /**
     * Set bonusType
     *
     * @param string $bonusType
     * @return Weapon
     */
    public function setBonusType($bonusType)
    {
        $this->bonusType = $bonusType;

        return $this;
    }

    /**
     * Get bonusType
     *
     * @return string 
     */
    public function getBonusType()
    {
        return $this->bonusType;
    }
        
    public function getDamageType(){
        return $this->damageType;
    }
    
    public function setDamageType($type){
        $this->damageType = $type;
        return $this;
    }
    
}
