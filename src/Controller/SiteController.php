<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Comment;
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
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('site/about.html.twig');
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
        $projects = $repo->findAllProjetByDate();
        
        return $this->render('site/projects.html.twig', [
            'projects' => $projects
        ]);
    }
    /**
     * @Route("/show_project/{id}", name="show_project")
     */
    public function show_project(Project $project, Request $request, ObjectManager $manager)
    {
        // $session = $request->getSession();
        // $userId = $session->get('id');

        $id = $this->getUser(); // pourquoi this?
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $comment->setCreatedAt(new \DateTime())
                    ->setProject($project)
                    ->setReported(true)
                    ->setUser($id);

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('show_project', ['id' => $project->getId()]);
        }

        return $this->render('site/show_project.html.twig', [
            'project' => $project,
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
}
