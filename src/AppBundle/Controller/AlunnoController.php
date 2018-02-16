<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\Type\AggiungiAlunnoType;
use AppBundle\Form\Type\AggiornaAlunnoType;
use AppBundle\Form\Type\ValutazioneType;
use AppBundle\Repository\AlunnoDoctrineRepository;

use Valutazione\Alunno\Command\AggiungiAlunnoCommand;
use Valutazione\Alunno\Command\AggiornaAlunnoCommand;
use Valutazione\Alunno\Command\ValutazioneCommand;
use Valutazione\Alunno\Entity\Alunno;

class AlunnoController extends Controller
{
    private $alunnoRepository;
    
    public function __construct(AlunnoDoctrineRepository $alunnoRepository)
    {
        $this->alunnoRepository = $alunnoRepository;
    }
    
    /**
     * Elenco alunni
     * @Route("/", name="alunni")
     */
    public function indexAction(Request $request)
    {
        $qb = $this->alunnoRepository->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qb->getQuery(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('alunno/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
    
    /**
     * Aggiungi alunno
     * @Route("/alunno/new", name="alunno_aggiungi")
     * @Method({"GET", "POST"})
     */
    public function aggiungiAction(Request $request)
    {
        $command = AggiungiAlunnoCommand::getCommand();
        $form = $this->createForm(AggiungiAlunnoType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->get('command_bus')->handle($command);
                $this->addFlash('success', 'Alunno inserito correttamente');
                return $this->redirectToRoute("alunni");
                // @codeCoverageIgnoreStart
            } catch (Exception $ex) {
                $this->addFlash('danger', 'Errore durante la creazione');
            }
            // @codeCoverageIgnoreEnd
        }
        return $this->render("alunno/aggiungi.html.twig", [
            'form' => $form->createView()
        ]);
    }
    
    /**
     * Visualizza anagrafica alunno e elenco voti
    * @Route("/alunno/{id}/voti", name="alunno_visualizza")
    * @Method({"GET", "POST"})
    */
    public function visualizzaAction(Alunno $alunno)
    {
        return $this->render('alunno/visualizza.html.twig', [
            'alunno' => $alunno
        ]);
    }
    
    /**
     * Aggiorna alunno
    * @Route("/alunno/{id}/aggiorna", name="alunno_aggiorna")
    * @Method({"GET", "POST"})
    */
    public function aggiornaAction(Alunno $alunno, Request $request)
    {
        $command = AggiornaAlunnoCommand::getCommand($alunno);
        $form = $this->createForm(AggiornaAlunnoType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->get('command_bus')->handle($command);
                $this->addFlash('success', 'Alunno modificato correttamente');
                return $this->redirectToRoute("alunno_visualizza", [
                    'id' => $alunno->getId()
                ]);
                // @codeCoverageIgnoreStart
            } catch (Exception $ex) {
                $this->addFlash('danger', 'Errore durante la modifica');
            }
            // @codeCoverageIgnoreEnd
        }
        return $this->render('alunno/aggiorna.html.twig', [
            'form' => $form->createView(),
            'alunno' => $alunno,
        ]);
    }
    
    /**
     * Modifica voti
     * @Route("/alunno/{id}/valuta", name="alunno_valuta")
     * @Method({"GET", "POST"})
     */
    public function valutaAction(Alunno $alunno, Request $request)
    {
        $command = ValutazioneCommand::getCommand($alunno);
        $form = $this->createForm(ValutazioneType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->get('command_bus')->handle($command);
                $this->addFlash('success', 'Valutazione modificata correttamente');
                return $this->redirectToRoute("alunno_visualizza", [
                    'id' => $alunno->getId()
                ]);
                // @codeCoverageIgnoreStart
            } catch (Exception $ex) {
                $this->addFlash('danger', 'Errore durante la modifica');
            }
            // @codeCoverageIgnoreEnd
        }
        return $this->render('alunno/valutazione.html.twig', [
            'alunno' => $alunno,
            'form' => $form->createView(),
        ]);
    }
}
