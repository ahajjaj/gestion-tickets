<?php

namespace App\DataFixtures;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;        
    }

    public function load(ObjectManager $manager)
    {
         $user = new User();
         $user -> setUsername('ahmad');
         $user -> setFullname('ahmed hajjaj');
         $user -> setEmail('admin');
         $user -> setPassword(
         $this->passwordEncoder->encodePassword(
             $user,'admin'
         ));
        $manager->persist($user);

        $manager->flush();
    }
}
