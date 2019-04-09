<?php

namespace App\Form;

use App\Entity\Wiki;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WikiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Titre'
            ])
            ->add('body', null, [
                'label' => 'Contenu'
            ])
            ->add('tags', null, [
                'label' => 'Thème(s)',
                'expanded' => true,
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Wiki::class,
        ]);
    }
}
