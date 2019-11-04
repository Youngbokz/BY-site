<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\EditUserForUserType;
use Doctrine\Common\Persistence\ObjectManager;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function index()
    {
        return $this->render('profile/dashboard.html.twig');
    }

    /**
     * @Route("/showProfile", name="show_profile")
     */
    public function showProfile()
    {
        return $this->render('profile/show_profile.html.twig');
    }

    /**
     * @Route("/editProfile/{id}", name="edit_profile")
     */
    public function editProfile(User $user, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(EditUserForUserType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // if(!$user->getId()){ //Si l'article n'a pas d'identifiant alors on crée une heure de création
            //     $user->setCreatedAt(new \DateTime());
            // }
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('show_profile');
        }

        return $this->render('profile/edit_profile.html.twig', [
            'formEditUserForUser' => $form->createView()
        ]);
    }

    /**
     * @Route("/userComments", name="user_comments")
     */
    public function userComments()
    {
        return $this->render('profile/comments.html.twig');
    }

    /**
     * @Route("/userReportedCom", name="user_reported_com")
     */
    public function userReportedCom()
    {
        return $this->render('profile/reported.html.twig');
    }
}
