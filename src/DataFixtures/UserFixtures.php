<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <= 10; $i ++)
        {
            $codezip = 64140;
            $mobilePhone = 66340098;
            $user = new User();
            $user->setLog("Pseudo $i")
                 ->setPassword("pass$i")
                 ->setFirstname("Prénom $i")
                 ->setLastname("Nom $i")
                 ->setAddress("$i rue du test")
                 ->setCity("Pau")
                 ->setCountry("FRANCE")
                 ->setEmail("pseudo$i@gmail.com")
                 ->setMobilePhone($mobilePhone)
                 ->setCodeZip($codezip)
                 ->setGender(true);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
