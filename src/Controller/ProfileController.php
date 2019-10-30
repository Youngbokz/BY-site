<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/editProfile", name="edit_profile")
     */
    public function editProfile()
    {
        return $this->render('profile/edit_profile.html.twig');
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
