<?php

namespace Thonior\MasterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Race
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Race
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
     * @ORM\Column(name="description", type="string", length=1024)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Universe", inversedBy="races")
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
     * @return Race
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
     * @return Race
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
	return $this->name;
    }

    /**
     * Set universe
     *
     * @param \Thonior\MasterBundle\Entity\Universe $universe
     * @return Race
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
}
