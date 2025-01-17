<?php

namespace App\Controller;

use App\Entity\Machines;
use App\Entity\Token;
use App\Form\MachinesType;
use App\Repository\MachinesRepository;
use App\Repository\TokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MachinesController extends AbstractController
{
    #[Route('/machines', name: 'machines.index', methods: ['GET'])]
    public function index(MachinesRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $machines = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('pages/machines/index.html.twig', [
            'machines'=> $machines
        ]);
    }

    #[Route('/machines/new', 'machines.new', methods: ['GET', 'POST'])]
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

    #[Route('/machines/reservation/{id}', 'machines.reservation', methods: ['GET', 'POST'])]
    public function reservation(EntityManagerInterface $manager, Machines $machine, $id, TokenRepository $repositoryToken): Response {
        if (!$repositoryToken->findOneBy(["machineId"=>$id])) {
            $machine->setState(1);
            $manager->persist($machine);
    
            $token = new Token();
            $token->setToken(bin2hex(random_bytes(60)))
                  ->setMachineId($id);
            $manager->persist($token);
            $manager->flush();
        }  

        return $this->redirectToRoute('home.index');  
    }

    #[Route('/machines/cancelation/{id}', 'machines.cancelation', methods: ['GET', 'POST'])]
    public function cancelation(EntityManagerInterface $manager, Machines $machine, TokenRepository $repositoryToken, $id): Response {
        $machine->setState(0);
        $manager->persist($machine);

        $token = $repositoryToken->findOneBy(['machineId' => $id]);
        $manager->remove($token);
        $manager->flush();

        return $this->redirectToRoute('machines.index');  
    }
}
