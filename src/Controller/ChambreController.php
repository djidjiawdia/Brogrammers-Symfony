<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Form\ChambreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ChambreController extends AbstractController
{
    /**
     * @Route("/chambres", name="room")
     */
    public function index()
    {
        return $this->render('chambre/index.html.twig', []);
    }

    /**
     * @Route("/chambre/nouveau", name="add_room")
     */
    public function add()
    {
        $chambre = new Chambre;
        $form = $this->createForm(ChambreType::class, $chambre);

        return $this->render('chambre/ajout.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
