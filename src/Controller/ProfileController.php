<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\Comment;
use App\Form\EditUserForUserType;
use App\Form\CommentType;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     * @Security("has_role('ROLE_USER')")
     */
    public function index(CommentRepository $comRepo)
    {
        $user = $this->getUser();
        $userId = $user->getId();

        $countUserComments = $comRepo->countAllCommentsOfUser($userId);
        $countUserReportedComents = $comRepo->countAllReportedOfUser($userId);
        
        
        return $this->render('profile/dashboard.html.twig', [
            'countUserComments' => $countUserComments,
            'countUserReportedComents' => $countUserReportedComents
        ]);
    }

    /**
     * @Route("/showProfile", name="show_profile")
     * @Security("has_role('ROLE_USER')")
     */
    public function showProfile(CommentRepository $comRepo)
    {
        $user = $this->getUser();
        $userId = $user->getId();

        $countComments = $comRepo->countAllCommentsOfUser($userId);

        return $this->render('profile/show_profile.html.twig', [
            'countComments' => $countComments
        ]);
    }

    /**
     * @Route("/editProfile/{id}", name="edit_profile")
     * @Security("has_role('ROLE_USER')")
     */
    public function editProfile(User $user, Request $request, ObjectManager $manager, CommentRepository $comRepo)
    {
        $user = $this->getUser();
        $userId = $user->getId();

        $countUserComments = $comRepo->countAllCommentsOfUser($userId);

        $form = $this->createForm(EditUserForUserType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('sucess', 'Votre profile à bien été mis à jour !');
            return $this->redirectToRoute('show_profile');
        }

        return $this->render('profile/edit_profile.html.twig', [
            'formEditUserForUser' => $form->createView(),
            'countUserComments' => $countUserComments
        ]);
    }

    /**
     * @Route("/userComments", name="user_comments")
     * @Security("has_role('ROLE_USER')")
     */
    public function userComments(PaginatorInterface $paginator, CommentRepository $repo, Request $request)
    {
        $user = $this->getUser();
        $userId = $user->getId();
        $comments = $paginator->paginate(
            $repo->findAllUserCommentQuery($userId), 
            $request->query->getInt('page', 1), 3
        );
        return $this->render('profile/comments.html.twig', [
            'comments' => $comments
        ]);
    }

    /**
     * @Route("/userDeleteCom/{id}", name="user_delete_com")
     * @Security("has_role('ROLE_USER')")
     */
    public function userDeletedCom(Comment $comment, ObjectManager $manager, CommentRepository $comRepo)
    {
        $id = $comment->getId();
        $comment = $comRepo->find($id);
        $userCom = strtoupper($comment->getUser()->getUsername());

        $manager->remove($comment);
        $manager->flush();
        $this->addFlash('sucess', 'Votre message, ' . $userCom . ', à bien été supprimé !');
        return $this->redirectToRoute('reported_com');
    }

    /**
     * @Route("/userReportedCom", name="user_reported_com")
     */
    public function userReportedCom(PaginatorInterface $paginator, CommentRepository $repo, Request $request)
    {
        $user = $this->getUser();
        $userId = $user->getId();
        $reportedCom = $paginator->paginate(
            $repo->findAllUserReportedCommentQuery($userId), 
            $request->query->getInt('page', 1), 3
        );
        
        return $this->render('profile/reported.html.twig', [
            'reportedCom' => $reportedCom
        ]);
    }

    /**
     * @Route("/userDeleteReportedCom/{id}", name="user_delete_reported_com")
     * @Security("has_role('ROLE_USER')")
     */
    public function userDeletedReportedCom(Comment $reportedCom, ObjectManager $manager, CommentRepository $comRepo)
    {
        $id = $reportedCom->getId();
        $reportedCom = $comRepo->find($id);
        $userReportedCom = strtoupper($reportedCom->getUser()->getUsername());

        $manager->remove($reportedCom);
        $manager->flush();
        $this->addFlash('sucess', 'Le message de ' . $userReportedCom . ' à bien été supprimé !');
        return $this->redirectToRoute('reported_com');
    }

    /**
     * @Route("/edit_message/{id}", name="edit_message")
     * @Security("has_role('ROLE_USER')")
     */
    public function edit_message(Comment $comment, Request $request, ObjectManager $manager)
    {
        // $id = $comRepo->getId();
        // $comment = $comRepo->findBy($id);
        
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
             
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash('sucess', 'Votre message à bien été modifié !');
            return $this->redirectToRoute('user_comments');
        }

        return $this->render('profile/edit_message.html.twig', [
            'commentForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/deleteOwnAccount/{id}", name="delete_own_account")
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteAccount(User $user, ObjectManager $manager, Request $request, UserRepository $userRepo)
    {
        $id = $user->getId();
        $user = $userRepo->find($id);
        
        // $manager->remove($user);
        // $manager->flush();
        // $this->addFlash('sucess', 'L\'utilisateur a bien été supprimé !');
        // return $this->redirectToRoute('home');


        if($user->getVisible() === false){
            $user->setVisible(1);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('sucess', 'Votre compte a bien été supprimé');
            return  $this->redirectToRoute('home');
        }
    } 
}
