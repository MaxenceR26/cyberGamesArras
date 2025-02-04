<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserPasswordType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user.index')]
    public function index(UserRepository $userRepository, Request $request, PaginatorInterface $paginator): Response {
        $users = $paginator->paginate(
            $userRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );


        
        return $this->render('pages/user/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/user/edit/{id}', name: 'user.edit')]
    #[Security("is_granted('ROLE_USER') and user === choosenUser or is_granted('ROLE_ADMIN')")]
    public function edit(User $choosenUser, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {
        $form = $this->createForm(UserType::class, $choosenUser);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($choosenUser, $form->getData()->getPlainPassword())) {
                $choosenUser->setUpdatedAt(new \DateTimeImmutable());
                $user = $form->getData();
                $manager->persist($user);
                $manager->flush();

                $this->addFlash('success',
                'Les informations ont bien été modifié');
                return $this->redirectToRoute('home.index');
            } else {
                $this->addFlash('warning',
                'Le mot de passe renseigné est incorrect');
            }


        }

        return $this->render('pages/user/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/user/edit-password/{id}', 'user.edit.password', methods: ['GET', 'POST'])]
    #[Security("is_granted('ROLE_USER') and user === choosenUser or is_granted('ROLE_ADMIN')")]
    public function editPassword(User $choosenUser, Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $manager): Response {

        $form = $this->createForm(UserPasswordType::class);
        

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            if ($hasher->isPasswordValid($choosenUser, $form->getData()['plainPassword'])) {
                $choosenUser->setUpdatedAt(new \DateTimeImmutable());
                $choosenUser->setPlainPassword(
                    $form->getData()['newPassword']
                );

                $manager->persist($choosenUser);
                $manager->flush();

                $this->addFlash('success',
                'Le mot de passe à bien été modifié');
                return $this->redirectToRoute('home.index');
            } else {
                $this->addFlash('warning',
                'Le mot de passe renseigné est incorrect');
            }
        }

        return $this->render('pages/user/edit_password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/user/delete/{id}', 'user.delete', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(User $user, EntityManagerInterface $manager): Response {
        
        if (!$user) {
            $this->addFlash(
                'warning',
                'L\'utilisateur n\'existe pas'
            );
        } else {
            $this->addFlash(
                'success',
                'Utilisateur supprimé avec succès'
            );
            $manager->remove($user);
            $manager->flush();
        }
        return $this->redirectToRoute('user.index');              
    }

    #[Route('/user/rankup/{id}', 'user.rankup', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function rankup(User $user, EntityManagerInterface $manager): Response {
        
        if (!$user) {
            $this->addFlash(
                'warning',
                'L\'utilisateur n\'existe pas'
            );
        } else {
            $this->addFlash(
                'success',
                'Utilisateur promu avec succès'
            );


            $users = $user->setRoles(["ROLE_ADMIN"]);

            $manager->persist($users);
            $manager->flush();
        }
        return $this->redirectToRoute('user.index');              
    }

    #[Route('/user/demote/{id}', 'user.demote', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function demote(User $user, EntityManagerInterface $manager): Response {
        
        if (!$user) {
            $this->addFlash(
                'warning',
                'L\'utilisateur n\'existe pas'
            );
        } else {
            $this->addFlash(
                'success',
                'Utilisateur destitué avec succès'
            );


            $users = $user->setRoles(["ROLE_USER"]);

            $manager->persist($users);
            $manager->flush();
        }
        if ($user == $this->getUser()) {
            return $this->redirectToRoute('home.index');
        } else {
            return $this->redirectToRoute('user.index');
        }
                      
    }
}
