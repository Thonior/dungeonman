<?php
namespace Thonior\MasterBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\OneToMany(targetEntity="Hero", mappedBy="author")
     */
    private $heroes;
    
    /**
     * @ORM\OneToMany(targetEntity="Campaign", mappedBy="author")
     */
    private $campaigns;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->heroes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->campaigns = new \Doctrine\Common\Collections\ArrayCollection();
        $this->roles = array('ROLE_USER');
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
     * Add heroes
     *
     * @param \Thonior\MasterBundle\Entity\Hero $heroes
     * @return User
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
     * Add campaigns
     *
     * @param \Thonior\MasterBundle\Entity\Campaign $campaigns
     * @return User
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
}
