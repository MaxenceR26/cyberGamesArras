<?php

namespace App\Controller;

use App\Entity\Machines;
use App\Entity\Token;
use App\Repository\MachinesRepository;
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
    #[Route('/token', name: 'token.index', methods:"GET")]
    #[IsGranted('ROLE_USER')]
    public function index(TokenRepository $repositorytoken, Request $request, PaginatorInterface $paginator): Response
    {

        $tokens = $paginator->paginate(
            $repositorytoken->findBy(['idUser' => $this->getUser()]),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('pages/token/index.html.twig', [
            'tokens'=> $tokens
        ]);
    }
}
