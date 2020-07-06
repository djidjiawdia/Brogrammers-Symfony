<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController
{
    /**
     * @Route("/", name="students")
     */
    public function index()
    {
        return $this->render('etudiant/index.html.twig', [
            'current' => 'students',
        ]);
    }

    /**
     * @Route("/etudiant/showTable", name="student_table")
     */
    public function getStudents() : Response
    {
        return $this->json(["code" => 200, "message" => $_POST], 200);
    }

    /**
     * @Route("/etudiants/nouveau", name="add_student")
     */
    public function add()
    {
        return $this->render('etudiant/ajout.html.twig', [
            'current' => 'students',
        ]);
    }
}
