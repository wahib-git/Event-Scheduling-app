<?php

namespace App\Controller;
use App\Entity\Event; // Assurez-vous d'importer l'entité Event
use App\Form\EventType; // Assurez-vous d'importer le formulaire EventType
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface; // Importation nécessaire
use Symfony\Component\HttpFoundation\Request; // Importation nécessaire

#[Route('/event')]
class EventController extends AbstractController
{
    #[Route('/', name: 'app_event')]
    public function listEvents(EventRepository $er): Response
    {
        $listEvents = $er->findAll();
        return $this->render('event/listEvents.html.twig',
            ['listeE'=>$listEvents]);
    }
    #[Route('/new', name: 'app_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('app_event');
        }

        return $this->render('event/new.html.twig', [
            'formE' => $form->createView()]);
    }

    #[Route('/{id}',name: 'event_delete', requirements:["id"=>"\d+"])]
    public function delete(EntityManagerInterface $em, EventRepository $er, $id): RedirectResponse
    {
        $event = $er->find($id);
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute('app_event');
    }

    #[Route('/search', name: 'searchE')]
    public function searchEvent(Request $request, EntityManagerInterface $em): Response
    {
        $nom = $request->request->get('eventName');

        $q = $em->createQuery('select e from App\Entity\Event e where e.nom = :n');
        $q->setParameter('n', $nom);

        $events = $q->getResult();

        return $this->render('event/searchEvent.html.twig', [
            'listeE' => $events,
        ]);
    }
    #[Route('/{id}/edit', name: 'event_update')]
    public function edit(Request $request, EntityManagerInterface $em, EventRepository $er, $id): Response
    {
        $event = $er->find($id);

        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('app_event');
        }

        return $this->render('event/edit.html.twig', [
            'formE' => $form->createView()
        ]);

    }

}