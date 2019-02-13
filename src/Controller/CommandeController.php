<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\ProduitCommande;
use App\Entity\Produit;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Session\Session;


/**
 * @Route("/commande")
 */
class CommandeController extends Controller
{
    /**
     * @Route("/", name="commande_index")
     */

    public function new(Request $request): Response
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $repo = $entityManager->getRepository(Produit::class);
            $commande->setCreatedAt(new \DateTime());
            $entityManager->persist($commande);
           

            // Insetion des lignes commande (dans ProduitCommande)
            
            $sess = new Session();
            $panier = $sess->get('panier');
            foreach ($panier as $id => $qte) {
                $pc = new ProduitCommande();
                $p = $repo->find($id);
                $pc->setProduit($p);
                $pc->setCommande($commande);
                $pc->setQte($qte);
                $pc->setPrix($p->getPrix());

                $entityManager->persist($pc);
            }
            $entityManager->flush();

            $numCmd = $commande->getId();

            return $this->redirectToRoute('commande_merci', ['num' => $numCmd]);
        }

        return $this->render('front/commande.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/merci/{num}", name="commande_merci")
     */

    public function merci($num)
    {
        return $this->render('front/merci.html.twig', ['num' => $num]);
    }

    
}
