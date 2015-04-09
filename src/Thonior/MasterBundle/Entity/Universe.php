<?php

namespace Thonior\MasterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Universe
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Universe
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
     * @ORM\OneToMany(targetEntity="Campaign", mappedBy="universe")
     */
    private $campaigns;
    
    /**
     * @ORM\OneToMany(targetEntity="Hero", mappedBy="universe")
     */
    private $heroes;
    
    /**
     * @ORM\OneToMany(targetEntity="Race", mappedBy="universe")
     */
    private $races;
    
    /**
     * @ORM\OneToMany(targetEntity="Job", mappedBy="universe")
     */
    private $jobs;

    /**
     * @ORM\OneToMany(targetEntity="Item", mappedBy="universe")
     */
    private $items;
    
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
     * @return Universe
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
     * @return Universe
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
     * Constructor
     */
    public function __construct()
    {
        $this->campaigns = new \Doctrine\Common\Collections\ArrayCollection();
        $this->heroes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->races = new \Doctrine\Common\Collections\ArrayCollection();
        $this->jobs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add campaigns
     *
     * @param \Thonior\MasterBundle\Entity\Campaign $campaigns
     * @return Universe
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
     * Add heroes
     *
     * @param \Thonior\MasterBundle\Entity\Hero $heroes
     * @return Universe
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
     * Add races
     *
     * @param \Thonior\MasterBundle\Entity\Race $races
     * @return Universe
     */
    public function addRace(\Thonior\MasterBundle\Entity\Race $races)
    {
        $this->races[] = $races;

        return $this;
    }

    /**
     * Remove races
     *
     * @param \Thonior\MasterBundle\Entity\Race $races
     */
    public function removeRace(\Thonior\MasterBundle\Entity\Race $races)
    {
        $this->races->removeElement($races);
    }

    /**
     * Get races
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRaces()
    {
        return $this->races;
    }

    /**
     * Add jobs
     *
     * @param \Thonior\MasterBundle\Entity\Job $jobs
     * @return Universe
     */
    public function addJob(\Thonior\MasterBundle\Entity\Job $jobs)
    {
        $this->jobs[] = $jobs;

        return $this;
    }

    /**
     * Remove jobs
     *
     * @param \Thonior\MasterBundle\Entity\Job $jobs
     */
    public function removeJob(\Thonior\MasterBundle\Entity\Job $jobs)
    {
        $this->jobs->removeElement($jobs);
    }

    /**
     * Get jobs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getJobs()
    {
        return $this->jobs;
    }
    
    /**
     * Add jobs
     *
     * @param \Thonior\MasterBundle\Entity\Job $jobs
     * @return Universe
     */
    public function addItem(\Thonior\MasterBundle\Entity\Item $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove jobs
     *
     * @param \Thonior\MasterBundle\Entity\Job $jobs
     */
    public function removeItem(\Thonior\MasterBundle\Entity\Item $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get jobs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItems()
    {
        return $this->items;
    }
    
    
    
    public function __toString() {
	return $this->name;
    }
}
