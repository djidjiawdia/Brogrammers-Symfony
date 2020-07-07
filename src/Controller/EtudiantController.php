<?php

namespace App\Controller;

use App\Repository\EtudiantRepository;
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
    public function getStudents(EtudiantRepository $repo) : Response
    {
        extract($_POST);
        $option = [];
        if(!empty($mat)){
            $option = ["matricule" => $mat];
        }elseif(!empty($type)){
            $option = ["type" => $type];
        }elseif(!empty($mat) && !empty($type)){
            $option = ["matricule" => $mat, "type" => $type];
        }
        $etudiant = $repo->findBy($option, [], $limit, $offset);
        $body = '';
        foreach($etudiant as $d){
            $tr = '
                <tr id="'. $d->getId() .'">
                    <td>'.$d->getMatricule() .'</td>
                    <td class="edit" id="prenom">'. $d->getPrenom().'</td>
                    <td class="edit" id="nom">'. strtoupper($d->getNom()).'</td>
                    <td class="edit" id="email">'. $d->getEmail().'</td>
                    <td class="edit" id="tel">'. $d->getTel().'</td>';
                    if($d->getType() == "boursier"){
                        $tr .= '<td>'. $d->getMontant().'</td>';
                        if($d->getStatut() == "logier"){
                            $tr .= '<td>'. $d->getChambre()->getNumero().'</td>';
                        }else{
                            $tr .= '<td>Néant</td>';
                        }
                    }else{
                        $tr .= '<td>XOF</td>
                            <td>'. $d->getAdresse().'</td>';
                    }
                    $tr .= '<td class="text-danger">
                        <button class="btn btn-danger deleteStud" id="'. $d->getId() .'"><span><i class="fas fa-trash"></i></span></button>
                    </td>
                </tr>
            ';
            $body .= $tr;
        }
        return $this->json(["code" => 200, "message" => $body]);
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
