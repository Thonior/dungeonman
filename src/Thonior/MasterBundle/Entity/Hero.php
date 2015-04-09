<?php

namespace Thonior\MasterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hero
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Hero
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
     * @ORM\OneToOne(targetEntity="Race")
     */
    private $race;

    /**
     * @var string
     *
     * @ORM\Column(name="alignment", type="string", length=255)
     */
    private $alignment;

    /**
     * @ORM\OneToOne(targetEntity="Job")
     */
    private $classes;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="media", type="string", length=255)
     */
    private $media;

    /**
     * @var string
     *
     * @ORM\Column(name="script", type="string", length=255)
     */
    private $script;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Item")
     * @ORM\JoinTable(name="hero_items",
     *	    joinColumns={@ORM\JoinColumn(name="hero_id", referencedColumnName="id")},
     *	    inverseJoinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id")}
     *	    )
     */
    private $inventory;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="campaigns")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $author;
    
    /**
     * @ORM\ManyToMany(targetEntity="Campaign", mappedBy="heroes")
     */
    private $campaigns;
    
    /**
     * @ORM\Column(name="health", type="integer")
     */
    private $health;
    
    /**
     * @ORM\ManyToOne(targetEntity="Universe", inversedBy="heroes")
     * @ORM\JoinColumn(name="universe_id", referencedColumnName="id")
     */
    private $universe;

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
     * @return Hero
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
     * Set race
     *
     * @param string $race
     * @return Hero
     */
    public function setRace($race)
    {
        $this->race = $race;

        return $this;
    }

    /**
     * Get race
     *
     * @return string 
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * Set alignment
     *
     * @param string $alignment
     * @return Hero
     */
    public function setAlignment($alignment)
    {
        $this->alignment = $alignment;

        return $this;
    }

    /**
     * Get alignment
     *
     * @return string 
     */
    public function getAlignment()
    {
        return $this->alignment;
    }

    /**
     * Set classes
     *
     * @param string $classes
     * @return Hero
     */
    public function setClasses($classes)
    {
        $this->classes = $classes;

        return $this;
    }

    /**
     * Get classes
     *
     * @return string 
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * Set level
     *
     * @param string $level
     * @return Hero
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Hero
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

    /**
     * Set media
     *
     * @param string $media
     * @return Hero
     */
    public function setMedia($media)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return string 
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set script
     *
     * @param string $script
     * @return Hero
     */
    public function setScript($script)
    {
        $this->script = $script;

        return $this;
    }

    /**
     * Get script
     *
     * @return string 
     */
    public function getScript()
    {
        return $this->script;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->inventory = new \Doctrine\Common\Collections\ArrayCollection();
        $this->campaigns = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set health
     *
     * @param integer $health
     * @return Hero
     */
    public function setHealth($health)
    {
        $this->health = $health;

        return $this;
    }

    /**
     * Get health
     *
     * @return integer 
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * Add inventory
     *
     * @param \Thonior\MasterBundle\Entity\Item $inventory
     * @return Hero
     */
    public function addInventory(\Thonior\MasterBundle\Entity\Item $inventory)
    {
        $this->inventory[] = $inventory;

        return $this;
    }

    /**
     * Remove inventory
     *
     * @param \Thonior\MasterBundle\Entity\Item $inventory
     */
    public function removeInventory(\Thonior\MasterBundle\Entity\Item $inventory)
    {
        $this->inventory->removeElement($inventory);
    }

    /**
     * Get inventory
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     * Set author
     *
     * @param \Thonior\MasterBundle\Entity\User $author
     * @return Hero
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

    /**
     * Add campaigns
     *
     * @param \Thonior\MasterBundle\Entity\Campaign $campaigns
     * @return Hero
     */
    public function addCampaign(\Thonior\MasterBundle\Entity\Campaign $campaigns)
    {
        $this->campaigns[] = $campaigns;

        return $this;
    }

    /**
     * Remove campaigns
     *
     * @param \Thonior\MasterBundle\Entity\Campaign $campaigns
     */
    public function removeCampaign(\Thonior\MasterBundle\Entity\Campaign $campaigns)
    {
        $this->campaigns->removeElement($campaigns);
    }

    /**
     * Get campaigns
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCampaigns()
    {
        return $this->campaigns;
    }

    /**
     * Set universe
     *
     * @param \Thonior\MasterBundle\Entity\Universe $universe
     * @return Hero
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
    
    /**********************************************************************************/
    
    private $isAuthor;
    
    public function getIsAuthor(){
        return $this->isAuthor;
    }
    
    public function setIsAuthor($isAuthor){
        $this->isAuthor = $isAuthor;
        return $this;
    }
    
}
