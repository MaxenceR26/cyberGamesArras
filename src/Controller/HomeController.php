<?php

namespace App\Controller;

use App\Repository\MachinesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name:'home.index', methods: ['GET'])]
    public function index(MachinesRepository $repository): Response
    {
        return $this->render('pages/home.html.twig', [
            'machines'=>$repository->findAll()
        ]);
    }
}