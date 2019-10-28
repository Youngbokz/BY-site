<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Comment;
// use Symfony\Component\Form\Extension\Core\Type\TextType;
// use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Entity\Contact;
use App\Entity\Project;
use App\Form\CommentType;
use App\Form\ContactType;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function show_project(Project $project, Request $request, ObjectManager $manager)
    {
        $user = new User();
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $comment->setCreatedAt(new \DateTime())
                    ->setProject($project)
                    ->setReported(true);
                    
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('show_project', ['id' => $project->getId()]);
        }

        return $this->render('site/show_project.html.twig', [
            'project' => $project,
            'user' => $user,
            'commentForm' => $form->createView()
        ]);
    }
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, ObjectManager $manager)
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            return $this->redirectionToRoute('site/contact.html.twig');
        }
        return $this->render('site/contact.html.twig', [
            'formContact' => $form->createView()
        ]);
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
}
