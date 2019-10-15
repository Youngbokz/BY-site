<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Project;

class ProjectFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <= 4; $i ++)
        {
            $project = new Project();
            $project->setName("Projet n°$i")
                    ->setDescription("Desciption du projet n°$i, que de réussite dans mes projets")
                    ->setCreatedAt(new \DateTime())
                    ->setImageUrl("img/leone-venter-VieM9BdZKFo-unsplash.jpg")
                    ->setAddress("#");
            $manager->persist($project);
        }
        $manager->flush();
    }
}
