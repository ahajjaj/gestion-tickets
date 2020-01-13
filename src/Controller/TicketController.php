<?php

namespace App\Controller;
use App\Entity\Issue;
use App\Form\IssueType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class TicketController extends AbstractController
{

    private $formFactory;
    private $entityManager;
    private $router;

    
public function __construct(FormFactoryInterface $formFactory, EntityManagerInterface $entityManager,
RouterInterface $router)
{
    $this->formFactory = $formFactory;
    $this->entityManager = $entityManager;
    $this->router = $router;
}

    /**
     * @Route("/ticket", name="ticket")
     */
    public function index()
    {
        $repository = $this -> getDoctrine()-> getRepository(Issue::class);
        $tickets = $repository->findAll();
        return $this->render('ticket/index.html.twig', [
        'ticket' => $tickets
        ]);
    }

    /**
     * @Route("/ticket/show/{id}", name="ticket_show")
     */
    public function show($id)
    {        
        
        $repository = $this -> getDoctrine()-> getRepository(Issue::class);
        $ticket = $repository->find($id);
        return $this->render('ticket/show.html.twig', [
        'ticket' => $ticket
        ]);
    }

    /**
     * @Route("/delete/{id}", name="ticket_delete")
     */
    public function delete(Issue $ticket){
        $this->entityManager->remove($ticket);
        $this->entityManager->flush();
        return new RedirectResponse(
            $this->router->generate('ticket')
        );
    }
   /**
     * @Route("/edit/{id}", name="ticket_edit")
     */
    public function edit(Issue $ticket,Request $request)
    {
        $form = $this->formFactory->create(IssueType::class,$ticket);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->flush();
            return new RedirectResponse(
                $this->router->generate('ticket')
            );
        }
        return $this->render('ticket/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/add", name="ticket_add")
     */
    public function add(Request $request)
    {
        $tickets = new Issue();
        $form = $this->formFactory->create(IssueType::class, $tickets);
        $form -> handleRequest($request);       
        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($tickets);
            $this->entityManager->flush();
            return new RedirectResponse(
                $this->router ->generate('ticket')
            );
        }
        return $this->render('ticket/add.html.twig', [
            'form' => $form->createView()
     ]);
    }
}
