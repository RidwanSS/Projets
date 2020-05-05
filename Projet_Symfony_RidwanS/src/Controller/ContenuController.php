<?php

namespace App\Controller;

use App\Entity\Contenu;
use App\Form\ContenuType;
use App\Repository\ContenuRepository;
use App\Repository\PanierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/contenu")
 */
class ContenuController extends AbstractController
{
    /**
     * @Route("/", name="contenu_index", methods={"GET"})
     */
    public function index(ContenuRepository $contenuRepository): Response
    {
        return $this->render('contenu/index.html.twig', [
            'contenus' => $contenuRepository->findAll(),
        ]);
    }


    /**
     * @Route("/{id}", name="delete_contenu", methods={"DELETE","GET"})
     */
    public function delete(Contenu $contenu=null, TranslatorInterface $translator){
        if($contenu != null){
            $pdo = $this->getDoctrine()->getManager();
            $pdo -> remove($contenu); 
            $pdo -> flush();

            $this-> addFlash("success", $translator->trans('flash.supppanier'));
        }
        else{
            $this-> addFlash("danger", $translator->trans('flash.unknownpan'));
        }

        return $this->redirectToRoute('contenu_index');
    }

    /**
     * @Route("/achete" , name="achete_contenu" , methods={"POST"} )
     */
    public function acheteContenu(PanierRepository $panierRepository, ContenuRepository $contenuRepository, TranslatorInterface $translator)
    {
        $panier = $panierRepository->findOneBy(['user' => $this->getUser(), 'etat' => false]);
        $contenu =  $contenuRepository->findBy(['panier' => $panier]);

        foreach($contenu as $cont)
        {
            $pdo=$this->getDoctrine()->getManager();

            //stock nécessaire
            $qt = $cont->getQte();
            $qtevalide = $cont->getProduit()->getStock() - $qt;

            if($qtevalide < 0)
            {
                $this->addFlash("danger", "Attention quantité trop importante" . $cont->getProduit()->getNom());
                return $this->redirectToRoute('contenu_index');
            }

            $cont->getProduit()->setStock($qtevalide);

            $pdo->persist($cont);
            $pdo->flush();
        }

        $panier->setDateAchat(new \DateTime());
        $panier->setEtat(true);

        $pdo->persist($panier);
        $pdo->flush();
        
        $this->addFlash("success", $translator->trans('flash.buypan'));
        return $this->redirectToRoute('contenu_index');
    }
}
