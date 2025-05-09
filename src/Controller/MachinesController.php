<?php

namespace App\Controller;

use App\Entity\HistoriqueMaintenance;
use App\Entity\Machines;
use App\Entity\Token;
use App\Entity\User;
use App\Form\MachinesType;
use App\Repository\MachinesRepository;
use App\Repository\TokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class MachinesController extends AbstractController
{
    #[Route('/machines', name: 'machines.index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(MachinesRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $machines = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('pages/machines/index.html.twig', [
            'machines'=> $machines
        ]);
    }

    #[Route('/machines/new', 'machines.new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $manager): Response {

        $machines = new Machines();
        $form = $this->createForm(MachinesType::class, $machines);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $machines = $form->getData();
            $manager->persist($machines);
            $manager->flush();
            
            $this->addFlash(
                'success',
                'Machines ajouté avec succès'
        );

            return $this->redirectToRoute('machines.index');
        }

        return $this->render('pages/machines/new.html.twig', [
            'form'=>$form->createView()
        ]);
    }

    #[Route('/machines/edit/{id}', 'machines.edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Machines $machines, Request $request, EntityManagerInterface $manager): Response {
        $form = $this->createForm(MachinesType::class, $machines);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $machines = $form->getData();
            $manager->persist($machines);
            $manager->flush();
            
            $this->addFlash(
                'success',
                'Machines modifié avec succès'
        );

            return $this->redirectToRoute('machines.index');
        }

        return $this->render('pages/machines/edit.html.twig', [
            'form'=>$form->createView()
        ]);
    }

    #[Route('/machines/delete/{id}', 'machines.delete', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Machines $machines, EntityManagerInterface $manager): Response {
        
        if (!$machines) {
            $this->addFlash(
                'warning',
                'La machine n\'existe pas'
            );
        } else {
            $this->addFlash(
                'success',
                'Machines supprimé avec succès'
            );
            $manager->remove($machines);
            $manager->flush();
        }
        return $this->redirectToRoute('machines.index');              
    }

    #[Route('/machines/maintenance/add/{id}', 'machines.maintenance.add', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function add_maintenance(Machines $machines, EntityManagerInterface $manager, Security $security): Response {
        if (!$machines) {
            $this->addFlash('warning', 'La machine n\'existe pas');
        } else {
            if ($machines->isState() != 1 && $machines->isMaintenance() != 1) {
                $machines->setMaintenance(1);
                $manager->persist($machines);

                $historique = new HistoriqueMaintenance();
                $historique->setMachine($machines);
                $historique->setUser($security->getUser());
                $historique->setHeureMaintenance(new \DateTime());

                $manager->persist($historique);
                $manager->flush();

                $this->addFlash('success', 'Maintenance activée pour cette machine');
            } else {
                $this->addFlash('warning', 'Maintenance impossible pour cette machine');
            }
        }

        return $this->redirectToRoute('machines.index');
    }

    #[Route('/machines/maintenance/remove/{id}', 'machines.maintenance.remove', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function remove_maintenance(Machines $machines, EntityManagerInterface $manager, Security $security): Response {
        if (!$machines) {
            $this->addFlash('warning', 'La machine n\'existe pas');
        } else {
            if ($machines->isMaintenance() == 1) {
                // Désactiver la maintenance de la machine
                $machines->setMaintenance(0);
                $manager->persist($machines);
    
                // Trouver l'historique de la maintenance en cours pour cette machine
                $historique = $manager->getRepository(HistoriqueMaintenance::class)
                    ->findOneBy(['machine' => $machines, 'finMaintenance' => null], ['heureMaintenance' => 'DESC']);
    
                if ($historique) {
                    $historique->setFinMaintenance(new \DateTime());
                    $manager->persist($historique);
                }
    
                $manager->flush();
    
                $this->addFlash('success', 'Maintenance retirée pour cette machine');
            } else {
                $this->addFlash('warning', 'La maintenance n\'est pas activée pour cette machine');
            }
        }
    
        return $this->redirectToRoute('machines.index');
    }
    

    #[IsGranted('ROLE_USER')]
    #[Route('/machines/reservation/{id}', 'machines.reservation', methods: ['GET', 'POST'])]
    public function reservation(EntityManagerInterface $manager, Machines $machine, $id, TokenRepository $repositoryToken): Response {
        // Vérifier si un token existe déjà pour cette machine et cet utilisateur
        if ($this->getUser()->getUserCredit() >= $machine->getPrice()) {
            $existingToken = $repositoryToken->findOneBy(["machineId" => $id, "id" => $this->getUser()->getId()]);

            if (!$existingToken) {
                do {
                    $newToken = bin2hex(random_bytes(60));
                    $tokenExists = $repositoryToken->findOneBy(["token" => $newToken]);
                } while ($tokenExists);
                $machine->setState(1);
                $manager->persist($machine);
    
                $user = $this->getUser()->setUserCredit($this->getUser()->getUserCredit() - $machine->getPrice());
                $manager->persist($user);
    
                $token = new Token();
                $token->setToken($newToken)
                    ->setMachineId($id)
                    ->setIdUser($this->getUser()->getId())
                    ->setMachineName($machine->getName());
                
                $manager->persist($token);
                $manager->flush();
            } else {
                $this->addFlash('info', 'Vous avez déjà réservé cette machine.');
            }
            return $this->redirectToRoute('home.index');
        } else {
            $this->addFlash('info', 'Vous n\'avez pas assez de fond.');
            return $this->redirectToRoute('credit.index');
        }
        

        
    }

    #[Route('/machines/cancelation/{id}', 'machines.cancelation', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function cancelation(EntityManagerInterface $manager, Machines $machine, TokenRepository $repositoryToken, $id): Response {
        $machine->setState(0);
        $manager->persist($machine);

        $token = $repositoryToken->findOneBy(['machineId' => $id]);
        $manager->remove($token);
        $manager->flush();

        return $this->redirectToRoute('machines.index');  
    }
}
