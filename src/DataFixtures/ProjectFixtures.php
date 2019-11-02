<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Project;
use App\Entity\Comment;
use App\Entity\User;

class ProjectFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        
        
        for($i = 1; $i <= 4; $i ++)
        {
            $project = new Project();
            $project->setName($faker->sentence())
                    ->setDescription($faker->paragraph())
                    ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                    ->setImageUrl($faker->imageUrl())
                    ->setAddress($faker->url());

            $manager->persist($project);

            // Je crée de faux commentaires pour les liés aux projets et aux utilisateurs
            for($j = 1; $j <= mt_rand(4, 6); $j ++)
            {
                $user = new User();
                $days = (new \DateTime())->diff($project->getCreatedAt())->days;
                
                $comment = new Comment();
                $comment->setProject($project)
                        ->setUser($user)
                        ->setReported(true)
                        ->setCreatedAt($faker->dateTimeBetween('-' . $days . 'days'))
                        ->setComment($faker->paragraph());

                $manager->persist($comment);  

                for($z = 1; $z <= 3; $z ++){
                    $user->setUsername($faker->name())
                         ->setPassword($faker->password())
                         ->setCreatedAt($faker->dateTimeBetween('-6 months'));
            
                    $manager->persist($user);
                }
            }
        }
        $manager->flush();
    }
}
