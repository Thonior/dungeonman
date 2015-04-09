<?php
// src/Acme/UserBundle/Entity/User.php

namespace Thonior\DungeonBundle\Entity;

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
     * @ORM\OneToMany(targetEntity="Hero", mappedBy="user")
     */
    private $heroes;
    
    /**
     * @ORM\OneToMany(targetEntity="Campaign", mappedBy="master")
     */
    private $mastering;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
    
    public function getHeroes(){
	return $this->heroes;
    }
    
    public function setHeroes($heroes){
	$this->heroes = $heroes;
    }
    
    public function addHero($hero){
	$this->heroes[] = $hero;
    }
    
    public function __toString() {
	return parent::__toString();
    }
}