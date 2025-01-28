<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserPasswordType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

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
}
