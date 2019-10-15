<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\Form\Extension\Core\Type\TextType;
// use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Project;
use App\Entity\User;
use App\Repository\ProjectRepository;
use App\Form\ProjectType;
use App\Form\UserType;

class SiteController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('site/home.html.twig');
    }
    /**
     * @Route("/cv", name="cv")
     */
    public function cv()
    {
        return $this->render('site/cv.html.twig');
    }
    /**
     * @Route("/skills", name="skills")
     */
    public function skills()
    {
        return $this->render('site/skills.html.twig');
    }
    /**
     * @Route("/projects", name="projects")
     */
    public function projects(ProjectRepository $repo)
    {
        $projects = $repo->findAll();
        return $this->render('site/projects.html.twig', [
            'projects' => $projects
        ]);
    }
    /**
     * @Route("/show_project/{id}", name="show_project")
     */
    public function show_project(Project $project)
    {
        return $this->render('site/show_project.html.twig', [
            'project' => $project
        ]);
    }
    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('site/contact.html.twig');
    }
    /**
     * @Route("/adminAddProject", name="admin_add_project")
     * @Route("/adminEditProject/{id}", name="admin_edit_project")
     */
    public function formProject(Project $project = null, Request $request, ObjectManager $manager)
    {
        if(!$project){
            $project = new Project(); // cette article est completement vide, mais pas nul
        }
        // $form = $this->createFormBuilder($project)
        //              ->add('name')
        //              ->add('description') 
        //              ->add('image_url')
        //              ->add('address')
        //              ->getForm(); //Me donne un formulaire en objet complexe
        // Toute cette partie est maintenant dans la classe ProjectType
        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if(!$project->getId()){ //Si l'article n'a pas d'identifiant alors on crée une heure de création
                $project->setCreatedAt(new \DateTime());
            }
            $manager->persist($project);
            $manager->flush();
            return $this->redirectToRoute('show_project', ['id' => $project->getId()]);
        }
        
        return $this->render('site/formProject.html.twig', [
            'formProject' => $form->createView(), // Pour avoir l'aspect affiche de form
            'editMode' => $project->getId() !== null // Boolean qui permet de voir si il y a un id ou pas ici il est en True donc qu il a un id donc qu'il est modifiable 
        ]);
    }
    /**
     * @Route("/subscribe", name="site_subscribe")
     */
    public function userSubscribe(Request $request, ObjectManager $manager)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //$user->setCreatedAt(new \DateTime());
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('site_connexion');
        }
        dump($user);
        return $this->render('site/subscribe.html.twig', [
            'formUserSubscribe' => $form->createView()
        ]);

    }
    /**
     * @Route("/connexion", name="site_connexion")
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
        return $this->render('site/connexion.html.twig', [
            'formUserConnexion' => $form->createView()
        ]);
    }
    /**
     * @Route("/user_profile", name="user_profile")
     */
    public function user_profile()
    {
        return $this->render('site/user_profile.html.twig');
    }
}
