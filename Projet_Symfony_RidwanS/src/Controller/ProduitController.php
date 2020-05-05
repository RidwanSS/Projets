<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Produit;
use App\Entity\Contenu;
use App\Form\ProduitType;
use App\Form\ContenuType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;


class ProduitController extends AbstractController
{
    /**
     * @Route("/", name="produit")
     */
    public function index(Request $request, TranslatorInterface $translator){
        //Affiche le produit et affiche le form d'ajout de produits pour les admins
        $pdo = $this -> getDoctrine()->getManager();
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $fichier = $form->get('imageUpload')->getData();
            
            if($fichier){
                $nomfichier = uniqid(). '.' .$fichier->guessExtension();

                try {
                    $fichier->move(
                        $this->getParameter('upload_dir'),
                        $nomfichier
                    );
                }
                catch (FileException $e){
                    $this->addFlash("danger", $translator->trans('file.error'));
                    return $this->redirectToRoute('produit');
                }

                $produit->setImage($nomfichier);
            }
            $pdo->persist($produit);   
            $pdo->flush();

            $this->addFlash("success", $translator->trans('flash.addproduct'));             
        }

        $produits = $pdo -> getRepository(Produit::class)->findAll();
        $users = $pdo -> getRepository(User::class)->findAll();

        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
            'form_produit_new' => $form->createView()
        ]);
        
    }

    /**
     * @Route("/produit/{id}", name="produit_show", methods={"GET","POST"})
     */
    public function produit(Request $request, Produit $produit=null, TranslatorInterface $translator){
        //Pour avoir la description du produit et avoir le formulaire d'ajout si on est membre

        if($produit !=null){
            $contenu=new Contenu($produit);
            $form = $this->createForm(ContenuType::class, $contenu);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $pdo = $this -> getDoctrine()->getManager();
                $pdo->persist($contenu);
                $pdo->flush();

                $this->addFlash("success", $translator->trans('flash.addpanier'));
            }
            
            return $this->render('produit/show.html.twig',[
                'produit'=> $produit,
                'form'=>$form->createView()
            ]);

        }
        else{
            $this-> addFlash("danger", $translator->trans('flash.unknownprod'));
            return $this->redirectToRoute('produit');
        }

    }

    /**
     * @Route("/produit/{id}/edit", name="produit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Produit $produit): Response
    {
        //Permet de faire la modification du produit fait par l'admin
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produit');
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/produit/{id}", name="produit_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Produit $produit, TranslatorInterface $translator): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($produit);
            $entityManager->flush();

            $this->addFlash("success", $translator->trans('flash.deleteproduct'));
        }else{
            $this->addFlash("danger", $translator->trans('flash.impossibleproduct'));
        }

        if ($produit->getImage() != null) {
            unlink($this->getParameter('upload_dir') . $produit->getImage());
        }

        return $this->redirectToRoute('produit');
    }
}