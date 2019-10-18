<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\RegistrationType;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    /**
     * @Route("/registration", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager){
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user->setCreatedAt(new \DateTime())
                 ->setRole("NotAdmin");

            $manager->persist($user);
            $manager->flush();
        }
        return $this->render('security/registration.html.twig', [
            'formRegistration' => $form->createView()
        ]);
    }

      /**
     * @Route("/connexion", name="security_connexion")
     */
    public function userConnexion(Request $request, ProjectRepository $repo)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //$user->setCreatedAt(new \DateTime());
            return $this->redirectToRoute('home');
        }
        return $this->render('security/connexion.html.twig', [
            'formUserConnexion' => $form->createView()
        ]);
    }
}
