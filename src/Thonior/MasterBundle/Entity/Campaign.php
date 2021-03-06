<?php

namespace Thonior\MasterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DoctrineExtensions\Taggable\Taggable;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Campaign
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Campaign implements Taggable
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="Chapter", mappedBy="campaign")
     */
    private $chapters;

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

    /**
     * @var string
     *
     * @ORM\Column(name="introduction", type="string", length=1024)
     */
    private $introduction;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="campaigns")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $author;
    
    /**
     * @ORM\ManyToMany(targetEntity="Hero", inversedBy="campaigns")
     * @ORM\JoinTable(name="campaigns_heros")
     */
    private $heroes;
    
    /**
     * @ORM\ManyToOne(targetEntity="Universe", inversedBy="campaigns")
     * @ORM\JoinColumn(name="universe_id", referencedColumnName="id")
     */
    private $universe;

    
    private $tags;

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
     * Set title
     *
     * @param string $title
     * @return Campaign
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set chapters
     *
     * @param string $chapters
     * @return Campaign
     */
    public function setChapters($chapters)
    {
        $this->chapters = $chapters;

        return $this;
    }

    /**
     * Get chapters
     *
     * @return string 
     */
    public function getChapters()
    {
        return $this->chapters;
    }
    
    public function hasChapters()
    {
        return count($this->chapters);
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
     * Set characters
     *
     * @param string $characters
     * @return Campaign
     */
    public function setCharacters($characters)
    {
        $this->characters = $characters;

        return $this;
    }

    /**
     * Get characters
     *
     * @return string 
     */
    public function getCharacters()
    {
        return $this->characters;
    }

    /**
     * Set introduction
     *
     * @param string $introduction
     * @return Campaign
     */
    public function setIntroduction($introduction)
    {
        $this->introduction = $introduction;

        return $this;
    }

    /**
     * Get introduction
     *
     * @return string 
     */
    public function getIntroduction()
    {
        return $this->introduction;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->chapters = new \Doctrine\Common\Collections\ArrayCollection();
        $this->heroes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add chapters
     *
     * @param \Thonior\MasterBundle\Entity\Chapter $chapters
     * @return Campaign
     */
    public function addChapter(\Thonior\MasterBundle\Entity\Chapter $chapters)
    {
        $this->chapters[] = $chapters;

        return $this;
    }

    /**
     * Remove chapters
     *
     * @param \Thonior\MasterBundle\Entity\Chapter $chapters
     */
    public function removeChapter(\Thonior\MasterBundle\Entity\Chapter $chapters)
    {
        $this->chapters->removeElement($chapters);
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

    /**
     * Add heroes
     *
     * @param \Thonior\MasterBundle\Entity\Hero $heroes
     * @return Campaign
     */
    public function addHero(\Thonior\MasterBundle\Entity\Hero $heroes)
    {
        $this->heroes[] = $heroes;

        return $this;
    }

    /**
     * Remove heroes
     *
     * @param \Thonior\MasterBundle\Entity\Hero $heroes
     */
    public function removeHero(\Thonior\MasterBundle\Entity\Hero $heroes)
    {
        $this->heroes->removeElement($heroes);
    }

    /**
     * Get heroes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHeroes()
    {
        return $this->heroes;
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
    
    /**********************************************************************************/
    
    private $isAuthor;
    
    public function getIsAuthor(){
        return $this->isAuthor;
    }
    
    public function setIsAuthor($isAuthor){
        $this->isAuthor = $isAuthor;
        return $this;
    }
    
    public function __toString() {
        return $this->title;
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
        return 'campaign';
    }

    public function getTaggableId()
    {
        return $this->getId();
    }
}
