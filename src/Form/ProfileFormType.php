<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'required' => false
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'required' => false
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'required' => false
            ])
            ->add('avatar', FileType::class, [
                'label' => 'Avatar',
                'required' => false
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'label'=>'Valider les modifications'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
