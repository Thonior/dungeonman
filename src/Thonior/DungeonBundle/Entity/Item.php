<?php

namespace Thonior\DungeonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Item
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type",type="string")
 * @ORM\DiscriminatorMap({"weapon" = "Weapon", "armor" = "Armor"})
 * 
 */
class Item
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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;


    /**
     * @var string
     *
     * @ORM\Column(name="extra", type="array", nullable=true)
     */
    private $extra;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="shop_price", type="integer")
     */
    private $shopPrice;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="sell_price", type="integer")
     */
    private $sellPrice;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="weight", type="integer")
     */
    private $weight;
    
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
     * @return Item
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
     * Set description
     *
     * @param string $description
     * @return Item
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    public function __toString() {
	return  $this->name;
    }

    /**
     * Set extra
     *
     * @param array $extra
     * @return Item
     */
    public function setExtra($extra)
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * Get extra
     *
     * @return array 
     */
    public function getExtra()
    {
        return $this->extra;
    }
}
