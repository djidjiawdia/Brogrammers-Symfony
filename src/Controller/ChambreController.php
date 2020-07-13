<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Entity\Etudiant;
use App\Form\ChambreType;
use App\Repository\ChambreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChambreController extends AbstractController
{
    private $repo;
    private $current;

    public function __construct(ChambreRepository $repo)
    {
        $this->repo = $repo;
        $this->current = "rooms";
    }

    /**
     * @Route("/chambres", name="rooms",methods={"GET"})
     */
    public function index(Request $request,ChambreRepository $chambreRepository): Response
    {
       $chambre=$chambreRepository->findAll();
       foreach ($chambre as $key => $value) {
           $current[]=[
            'id'=> $value->getId(),
            'numero' =>$value->getNumero(),
           'type' =>$value->getType(),
           'batiment' =>$value->getBatiment()->getId()
        
       ];
       }
             return $this->render('chambre/index.html.twig', [
            'current' =>  $current
        ]);
    }
    

    /**
     * @Route("chambres/delete", name="delete_chambre")
     */
    public function delete(ChambreRepository $repo, EntityManagerInterface $em) : Response
    {
        $chambre = $repo->findOneBy(['id' => $_POST['id']]);
        $em->remove($chambre);
        $em->flush();
        return $this->json(['code' => 200, 'message' => 'supprimé'], 200);
        
    }

    /**
     * @Route("/chambres/nouveau", name="add_room")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $chambre = new Chambre;
        // $chambre->setNumero('001-0001');
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
            "current" => $this->current,
            "id" => $id
        ]);
    }
}

