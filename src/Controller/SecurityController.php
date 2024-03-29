<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\RegistrationType;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface; // replace use Doctrine\Common\Persistence\ObjectManager; because of a Doctrine update. 


class SecurityController extends AbstractController
{
    /**
     * @Route("/registration", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder){
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user->setCreatedAt(new \DateTime());
            $user->setVisible(0);
            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();
            $this->addFlash('connect', 'Vous avez bien été enregistré ! Connectez-vous ');
            return $this->redirectToRoute('security_connexion');
        }
        return $this->render('security/registration.html.twig', [
            'formRegistration' => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="security_connexion")
     */
    public function userConnexion(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) 
        {
            $this->addFlash('success', 'Vous êtes bien connecté(e) !');
            return $this->redirectToRoute('home');
        }
        elseif($form->isSubmitted() && !$form->isValid()){
            $messageError = 'Essayez à nouveau ou créer un nouveau compte !';
        }
        return $this->render('security/connexion.html.twig',[
            'formConnexion' => $form->createView()
            // 'messageError' => $messageError
        ]);
    }

    /**
     * @Route("/disconnexion", name="security_disconnexion")
     */
    public function disconnexion(){
    }
}
