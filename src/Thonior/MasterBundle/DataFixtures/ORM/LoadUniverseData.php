<?php
namespace Thonior\MasterBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Thonior\MasterBundle\Entity\Universe;

class LoadUniverseData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $universes = array(
            "D&D" => array(
                "name" => "Dungeons & Dragons",
                "description" => "Faerun"
            ),
            "LOTR" => array(
                "name" => "The Lord of The Rings",
                "description" => "Middle Earth"
            ),
        );
        foreach($universes as $uni){
            $universe = new Universe();
            $universe->setName($uni['name']);
            $universe->setDescription($uni['description']);

            $manager->persist($universe);
            $manager->flush();
        }
        echo "ok";
    }
}