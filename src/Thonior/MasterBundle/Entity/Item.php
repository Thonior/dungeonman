<?php

namespace Thonior\MasterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DoctrineExtensions\Taggable\Taggable;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Item
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type",type="string")
 * @ORM\DiscriminatorMap({"weapon" = "Weapon", "armor" = "Armor", "misc" = "Item"})
 * 
 */
class Item implements Taggable
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
     * @ORM\Column(name="description", type="text")
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
    
    /************************************/
    
    private $isAuthor;
    
    public function getIsAuthor(){
        return $this->isAuthor;
    }
    
    public function setIsAuthor($isAuthor){
        $this->isAuthor = $isAuthor;
        return $this;
    }
    
    private $type = 'item';
    
    public function getType(){
        return $this->type;
    }
    
    public function setType($type){
        $this->type = $type;
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
        return 'item';
    }

    public function getTaggableId()
    {
        return $this->getId();
    }
    
}
