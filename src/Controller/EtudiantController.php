<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
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
                    <td class="edit" id="setPrenom">'. $d->getPrenom().'</td>
                    <td class="edit" id="setNom">'. strtoupper($d->getNom()).'</td>
                    <td class="edit" id="setEmail">'. $d->getEmail().'</td>
                    <td class="edit" id="setTel">'. $d->getTel().'</td>';
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
     * @Route("/etudiant/add", name="add_student")
     */
    public function add()
    {
        $etudiant=new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
       return $this->render('etudiant/ajout.html.twig', [
        'form' => $form->createView(),
        'current' => 'student'
    ]);
    }
    /**
     * @Route("/etudiant/update", name="update_student")
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
     * @Route("/etudiant/delete", name="delete_student")
     */
    public function delete(EtudiantRepository $repo, EntityManagerInterface $em) : Response
    {
        $etudiant = $repo->findOneBy(['id' => $_POST['id']]);
        $em->remove($etudiant);
        $em->flush();
        return $this->json(['code' => 200, 'message' => 'supprimé'], 200);
    }
}
