<?php

namespace App\Controller;

use App\Entity\Token;
use App\Repository\TokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TokenController extends AbstractController
{
    #[Route('/token', name: 'token.index')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(TokenRepository $token, Request $request, PaginatorInterface $paginator): Response
    {

        $tokens = $paginator->paginate(
            $token->findBy(['idUser' => $this->getUser()]),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('pages/token/index.html.twig', [
            'tokens'=> $tokens
        ]);
    }
}
