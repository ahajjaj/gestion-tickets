<?php

namespace App\DataFixtures;
use App\Entity\Issue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=0; $i<9; $i++){

            $ticket= new issue();
            $ticket -> setQuestion ('Question'.rand(0,20));
            $ticket -> setResponse ('Response'.rand(0,20));
    
            $manager->persist($ticket);
        }

        $manager->flush();
    }
}
