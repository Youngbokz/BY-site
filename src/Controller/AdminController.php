<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Project;
use App\Entity\User;
use App\Form\ProjectType;
use App\Form\EditUserType;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use App\Repository\CommentRepository;
use Doctrine\Common\Persistence\ObjectManager;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function dashboard(UserRepository $userRepo, CommentRepository $comRepo, ProjectRepository $projectRepo)
    {
        $countUsers = $userRepo->countAllUser();
        $countComments = $comRepo->countAllComment();
        $countProjects = $projectRepo->countAllProject();

        return $this->render('admin/dashboard.html.twig', [
            'countUsers' => $countUsers,
            'countComments' => $countComments,
            'countProjects' => $countProjects
        ]);
    }

    /**
     * @Route("/adminUserCom", name="admin_user_com")
     */
    public function adminUserCom(CommentRepository $repo)
    {   
        $comments = $repo->findAllWithUser();

        return $this->render('admin/comments.html.twig', [
            'comments' => $comments
        ]);
    }

    /**
     * @Route("/RepotedCom", name="reported_com")
     */
    public function reportedCom(CommentRepository $repo)
    {
        $comments = $repo->findAllReportedComment();

        return $this->render('admin/reported.html.twig', [
            'comments' => $comments
        ]);
    }

    /**
     * @Route("/adminProjects", name="admin_projects")
     */
    public function adminProjects(ProjectRepository $repo)
    {
        $projects = $repo->findAllProjetByDate();

        return $this->render('admin/projects.html.twig', [
            'projects' => $projects
        ]);
    }

    /**
     * @Route("/subscribers", name="subscribers")
     */
    public function subscribers(UserRepository $repo)
    {
        $users = $repo->findAllUserByDate();

        return $this->render('admin/subscribers.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/adminProfile", name="admin_profile")
     */
    public function adminProfile(ProjectRepository $repo)
    {
        $projects = $repo->findAll();
        return $this->render('admin/profile.html.twig', [
            'projects'=> $projects
        ]);
    }

    /**
     * @Route("/adminEditProfile/{id}", name="admin_edit_profile")
     */
    public function adminEditProfile(User $user, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(EditUserType::class, $user);

        $form->handleRequest($request);//analyse la requete HTTP
        if($form->isSubmitted() && $form->isValid()){
            // if(!$user->getId()){ //Si l'article n'a pas d'identifiant alors on crée une heure de création
            //     $user->setCreatedAt(new \DateTime());
            // }
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('admin_profile');
        }

        return $this->render('admin/edit_profile.html.twig', [
            'formEditUser' => $form->createView()
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
        
        return $this->render('admin/formProject.html.twig', [
            'formProject' => $form->createView(), // Pour avoir l'aspect affiche de form
            'editMode' => $project->getId() !== null // Boolean qui permet de voir si il y a un id ou pas ici il est en True donc qu il a un id donc qu'il est modifiable 
        ]);
    } 
}
