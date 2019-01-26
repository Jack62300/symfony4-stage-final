<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Secteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;



class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $secteur = new Secteur();
        // $repo = $this->getDoctrine()->getRepository(Secteur::class);
        // $secteur = $repo->findAll();
        
        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('email')
            ->add('content', TextareaType::class)
            ->add('secteur', EntityType::class, [
                'class' => Secteur::class,
                'choice_label' => 'name'
            ]);
           
            
            
            
            // ['Secteur' => [

            
            //     foreach($secteurs in $secteur)
            //     {
            //         'choice_label' => 'Name',
                    
            //     },
            //     ]
            // ])
            
           
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
