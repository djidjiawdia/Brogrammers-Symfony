<?php

namespace App\Form;

use App\Entity\Batiment;
use App\Entity\Chambre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChambreType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Individuel' => 'indiv',
                    'A Deux' => 'duo',
                ],
                'expanded' => true,
            ])
            ->add('batiment', EntityType::class, [
                'class' => Batiment::class,
                'choice_label' => function(Batiment $bat){
                    return $bat->getLibele();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chambre::class,
        ]);
    }
}
