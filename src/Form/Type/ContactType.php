<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('surname', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('subject', TextType::class, [
                'label' => 'Sujet'
            ])
            ->add('email', TextType::class, [
                'label' => 'Email'
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'attr' => [
                    'rows' => 5
                ]
            ])
            ->add('Envoyer', SubmitType::class, [
                'label' => 'Envoyer',
            ]);
    } 
}