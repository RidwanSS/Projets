<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ContenuRepository;
use App\Repository\PanierRepository;

class PanierController extends AbstractController
{
    /**
     * @Route("user/commande", name="commande")
     */
    public function index(PanierRepository $panierRepository, ContenuRepository $contenuRepository)
    {   
        $ancienpanier = $panierRepository->findBy(['user' => $this->getUser()]);
        
        return $this->render('panier/index.html.twig', [
            'ancienpanier' =>  $ancienpanier,
            'anciencontenu' =>  $contenuRepository->findBy(['panier' => $ancienpanier]),
        ]);
    }

}
