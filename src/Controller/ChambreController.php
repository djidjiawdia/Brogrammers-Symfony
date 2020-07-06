<?php

namespace App\Controller;

use App\Entity\Batiment;
use App\Entity\Chambre;
use App\Form\ChambreType;
use App\Repository\ChambreRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ChambreController extends AbstractController
{
    private $repo;

    public function __construct(ChambreRepository $repo)
    {
        $this->repo = $repo;   
    }

    /**
     * @Route("/chambres", name="rooms")
     */
    public function index()
    {
        return $this->render('chambre/index.html.twig', [
            'current' => 'rooms'
        ]);
    }

    /**
     * @Route("/chambre/nouveau", name="add_room")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $chambre = new Chambre;
        $chambre->setNumero('001-0001');
        $last = $this->repo->findOneBy([], ['id' => 'desc']);
        if($last){
            $id = $last->getId();
        }else{
            $id = 0;
        }
        $form = $this->createForm(ChambreType::class, $chambre);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($chambre);
            $em->flush();
            return $this->redirectToRoute('rooms');
        }
        return $this->render('chambre/ajout.html.twig', [
            "form" => $form->createView(),
            "current" => "rooms",
            "id" => $id
        ]);
    }
}
