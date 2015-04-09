<?php

namespace Thonior\MasterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Item
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type",type="string")
 * @ORM\DiscriminatorMap({"weapon" = "Weapon", "armor" = "Armor", "misc" = "Item"})
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
     * @ORM\ManyToOne(targetEntity="Universe", inversedBy="items")
     * @ORM\JoinColumn(name="universe_id", referencedColumnName="id")
     */
    private $universe;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="items")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $author;
    
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
    
    /**
     * Set universe
     *
     * @param \Thonior\MasterBundle\Entity\Universe $universe
     * @return Campaign
     */
    public function setUniverse(\Thonior\MasterBundle\Entity\Universe $universe = null)
    {
        $this->universe = $universe;

        return $this;
    }

    /**
     * Get universe
     *
     * @return \Thonior\MasterBundle\Entity\Universe 
     */
    public function getUniverse()
    {
        return $this->universe;
    }
    
    /**
     * Set author
     *
     * @param \Thonior\MasterBundle\Entity\User $author
     * @return Campaign
     */
    public function setAuthor(\Thonior\MasterBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Thonior\MasterBundle\Entity\User 
     */
    public function getAuthor()
    {
        return $this->author;
    }
    
    public function getShopPrice(){
        return $this->shopPrice;
    }
    
    public function setShopPrice($price){
        $this->shopPrice = $price;
        return $this;
    }
    
    public function getSellPrice(){
        return $this->sellPrice;
    }
    
    public function setSellPrice($price){
        $this->sellPrice = $price;
        return $this;
    }
    
    public function getWeight(){
        return $this->weight;
    }
    
    public function setWeight($weight){
        $this->weight = $weight;
        return $this;
    }
    /************************************/
    
    private $isAuthor;
    
    public function getIsAuthor(){
        return $this->isAuthor;
    }
    
    public function setIsAuthor($isAuthor){
        $this->isAuthor = $isAuthor;
        return $this;
    }
    
    private $type;
    
    public function getType(){
        return $this->type;
    }
    
    public function setType($type){
        $this->type = $type;
        return $this;
    }
    
    
}
