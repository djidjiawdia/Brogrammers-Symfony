<?php

namespace App\Controller;

use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 */
class EtudiantController extends AbstractController
{
    /**
     * @Route("/etudiants", name="students")
     */
    public function index(EtudiantRepository $repo)
    {
        return $this->render('etudiant/index.html.twig', [
            'current' => 'students',
            'etudiants' => $repo->findAll()
        ]);
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

    /**
     * @Route("/etudiants/update", name="update_student")
     */
    public function update(EtudiantRepository $repo, EntityManagerInterface $em) : Response
    {
        extract($_POST);
        $etudiant = $repo->findOneBy(['id' => $id]);
        $etudiant->{$champ}($val);
        $em->flush();
        return $this->json(['code' => 200, 'message' => 'modifié'], 200);
    }

    /**
     * @Route("/etudiants/delete", name="delete_student")
     */
    public function delete(EtudiantRepository $repo, EntityManagerInterface $em) : Response
    {
        $etudiant = $repo->findOneBy(['id' => $_POST['id']]);
        $em->remove($etudiant);
        $em->flush();
        return $this->json(['code' => 200, 'message' => 'supprimé'], 200);
    }
}
