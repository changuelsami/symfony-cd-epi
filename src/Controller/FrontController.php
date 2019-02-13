<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;
use App\Entity\Produit;

use Symfony\Component\HttpFoundation\Session\Session;

class FrontController extends Controller
{
    /**
     * @Route("/", name="front")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Categorie::class);
        $liste = $repo->findAll();  
        return $this->render('front/index.html.twig', ['liste' => $liste]);
    }

    /**
     * @Route("/categorie/{id}", name="la_categorie")
     */
    public function categorie(Categorie $categorie)
    {       
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Produit::class);
        $produits = $repo->findByCategorie($categorie);
        return $this->render('front/produits.html.twig', 
                            ['cat' => $categorie, 'produits' => $produits]);
    }

    /**
     * @Route("/panier/ajouter/{id}", name="panier_ajout")
     */
    public function panierAjouter($id) {
        $sess = new Session();

        $panier = $sess->get('panier');
        @$panier[$id]++; // $panier[$id] = $panier[$id] + 1;
        $sess->set('panier', $panier);

        return $this->redirectToRoute('panier_details');
    }

    /**
     * @Route("/panier/details", name="panier_details")
     */
    public function panierDetails() {
        

        return $this->render('front/panier.html.twig');
    }

}
