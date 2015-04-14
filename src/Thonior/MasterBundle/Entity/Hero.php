<?php

namespace Thonior\MasterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DoctrineExtensions\Taggable\Taggable;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Hero
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Hero implements Taggable
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="script", type="text")
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
     * @var integer
     *
     * @ORM\Column(name="rating", type="integer")
     */
    private $rating = 0;
    
     /**
     * @var integer
     *
     * @ORM\Column(name="rates", type="integer")
     */
    private $rates = 0;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="total_rate", type="integer")
     */
    private $totalRate = 0;
    
    private $tags;
    
    private $temp;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;
    
    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;
    
    
    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/heroes';
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
    
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->getFile()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->path);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $file = $this->getAbsolutePath();
        if ($file) {
            unlink($file);
        }
    }

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
     * Set rating
     *
     * @param integer $rating
     * @return Campaign
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer 
     */
    public function getRating()
    {
        return $this->rating;
    }
    
    
    /**
     * Set rates
     *
     * @param integer $rates
     * @return Campaign
     */
    public function setRates($rates)
    {
        $this->rates = $rates;

        return $this;
    }
    
    public function addRate(){
        $this->rates = $this->rates+1;
        
        return $this;
    }

    /**
     * Get rates
     *
     * @return integer 
     */
    public function getRates()
    {
        return $this->rates;
    }
    
    /**
     * Set rates
     *
     * @param integer $rates
     * @return Campaign
     */
    public function setTotalRate($rate)
    {
        $this->totalRate = $rate;

        return $this;
    }
    
    public function addTotalRate($rate){
        $this->totalRate = $this->totalRate + $rate;
        
        return $this;
    }

    /**
     * Get rates
     *
     * @return integer 
     */
    public function getTotalRate()
    {
        return $this->totalRate;
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
    
     public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }
    
    public function getTags()
    {
        $this->tags = $this->tags ?: new ArrayCollection();

        return $this->tags;
    }

    public function getTaggableType()
    {
        return 'hero';
    }

    public function getTaggableId()
    {
        return $this->getId();
    }
    
}
