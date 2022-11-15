<?php

namespace App\Controller;

use App\Entity\Quack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\QuackFormType;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class QuackController extends AbstractController
{
    #[Route('/quack', name: 'app_quack')]
    public function index(): Response
    {
        return $this->render('quack/index.html.twig', [
            'controller_name' => 'QuackController',
        ]);
    }

    #[Route('/add-quack', name: 'add_quack')]
    public function addQuack(Request $request, PersistenceManagerRegistry $doctrine): Response
    {
        $quack = new Quack();
        $quackForm = $this->createForm(QuackFormType::class, $quack);
        $quackForm->handleRequest($request);
        if($quackForm->isSubmitted() && $quackForm->isValid())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($quack);
            $entityManager->flush();
        }

        return $this->render("quack/quack-form.html.twig", [
            "form_title" => "Ajouter un quack",
            "form_quack" => $quackForm->createView(),
        ]);
    }

    #[Route('/quacks', name: 'quacks')]
    public function getQuacks(PersistenceManagerRegistry $doctrine): Response
    {
        $quacks = $doctrine->getRepository(Quack::class)->findAll();

        return $this->render('quack/quacks.html.twig', [
            "quacks" => $quacks,
        ]);
    }

    #[Route('/quack/{id}', name: 'quack')]
    public function getQuack(PersistenceManagerRegistry $doctrine, $id): Response
    {
        $quack = $doctrine->getRepository(Quack::class)->find($id);

        return $this->render('quack/quack.html.twig', [
            "quack" => $quack,
        ]);
    }
    #[Route('/remove-quack/{id}', name: 'remove-quack')]
    public function removeQuack(PersistenceManagerRegistry $doctrine, $id): Response
    {

        $em = $this->getDoctrine()->getEntityManager();
        $quack = $em->getRepository(Quack::class)->find($id);
        var_dump($quack);
        $em->remove($quack);
        $em->flush();


/*        $quack = $doctrine->getRepository(Quack::class)->find($id);
        var_dump($quack);
        $quack->remove($quack);
        $quack->flush();*/


        return $this->render('quack/test.html.twig');
    }
}
