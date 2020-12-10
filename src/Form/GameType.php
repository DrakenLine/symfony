<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Game;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'nom'
            ])
            ->add('description', TextType::class)
            ->add('imageFile', VichImageType::class, [
                'label' => 'pochette du jeu',
                'required' => false
            ])
            ->add('category', EntityType::class, [
                'class'=>Category::class,
                'choice_label' => 'name' //liste déroulante
            ])
            ->add('tags', Select2EntityType::class, [
                'multiple' => true,
                'remote_route' => 'select_tag',
                'remote_params' => [], // static route parameters for request->query
                'class' => Tag::class,
                'primary_key' => 'id',
                'text_property' => 'name',
                'minimum_input_length' => 2,
                'page_limit' => 10,
                'allow_clear' => true,
                'delay' => 250,
                'cache' => true,
                'cache_timeout' => 60000, // if 'cache' is true
                'language' => 'fr',
                'placeholder' => 'Selectionner un tag',
            ])
            ->add('submit', SubmitType::class, [
                'label'=>'Ajouter un jeu'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
