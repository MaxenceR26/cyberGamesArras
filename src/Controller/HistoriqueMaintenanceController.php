<?php

namespace App\Controller;

use App\Entity\HistoriqueMaintenance;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoriqueMaintenanceController extends AbstractController
{
    #[Route('/historique-maintenance', name: 'historique.maintenance')]
    #[IsGranted('ROLE_ADMIN')]
    public function historiqueMaintenance(Request $request, EntityManagerInterface $em): Response
    {
        $userId = $request->query->get('user');
        $repo = $em->getRepository(HistoriqueMaintenance::class);

        $historiques = $userId
            ? $repo->findBy(['user' => $userId])
            : $repo->findAll();

        $users = $em->getRepository(User::class)->findAll();

        return $this->render('pages/historique-maintenance.html.twig', [
            'historiques' => $historiques,
            'users' => $users,
        ]);
    }

}
