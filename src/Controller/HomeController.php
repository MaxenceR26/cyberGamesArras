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

    #[Route('/about', name:'about.index', methods: ['GET'])]
    public function about(): Response
    {
        return $this->render('pages/about.html.twig');
    }

    #[Route('/metions-legales', name:'conform.legal', methods: ['GET'])]
    public function legal(): Response
    {
        return $this->render('legal.html.twig');
    }

    #[Route('/cgu', name:'conform.cgu', methods: ['GET'])]
    public function cgu(): Response
    {
        return $this->render('cgu.html.twig');
    }

    #[Route('/cgv', name:'conform.cgv', methods: ['GET'])]
    public function cgv(): Response
    {
        return $this->render('cgv.html.twig');
    }

    #[Route('/politique-confidentialite', name:'conform.polconf', methods: ['GET'])]
    public function polConf(): Response
    {
        return $this->render('politique_confidentialite.html.twig');
    }
}