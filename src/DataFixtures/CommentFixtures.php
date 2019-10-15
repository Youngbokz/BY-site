<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Comment;

class CommentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <= 20; $i ++)
        {
            $a = 1;
            $comment = new Comment();
            $comment->setProjectId($a)
                    ->setAuthor("Pseudo $i")
                    ->setReported(true)
                    ->setComment("<p> Ici s'affiche le commentaire infini et à changer en 255 varchar; le commentaire $i");
            $manager->persist($comment);
        }
        

        $manager->flush();
    }
}
