<?php

namespace App\Controller;

use App\Entity\Transactions;
use App\Entity\User;
use App\Repository\BoutiqueRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreditController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/credit', name: 'credit.index', methods:['GET'])]
    public function index(BoutiqueRepository $repository): Response
    {
        return $this->render('pages/credit/index.html.twig', [
            'boutique' => $repository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/credit/buy/{id}', name: 'credit.buy', methods:['GET', 'POST'])]
    public function buyCredit(BoutiqueRepository $repository, $id, EntityManagerInterface $manager): Response 
    {
        $boutique = $repository->findBy(['id'=>$id]);

        $transactions = new Transactions();
        $randomString = bin2hex(random_bytes(5));
        $reference = "#ARGAME" . "-" . $randomString;
        $transactions->setUserId($this->getUser()->getId())
        ->setAmountCredit($boutique[0]->getCreditsAmount())
        ->setTotalPrice($boutique[0]->getPrice())
        ->setMethod('EUR')
        ->setState('Valide')
        ->setReference($reference);
        $manager->persist($transactions);

        $users = $this->getUser()->setuserCredit($this->getUser()->getUsercredit() + $boutique[0]->getCreditsAmount());
        $manager->persist($users);
        $manager->flush();

        return $this->redirectToRoute('credit.index');
    }
}
