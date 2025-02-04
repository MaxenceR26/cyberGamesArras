<?php

namespace App\Controller;

use App\Repository\TransactionsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransactionController extends AbstractController
{
    #[Route('/transaction', name: 'transaction.index')]
    public function index(TransactionsRepository $transaction, Request $request, PaginatorInterface $paginator): Response
    {
        $transactions = $paginator->paginate(
            $transaction->findBy(['user_id' => $this->getUser()->getId()]),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('pages/transaction/historique.html.twig', ['transactions' => $transactions]);
    }
}
