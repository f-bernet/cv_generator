<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Network;
use App\Entity\Experience;
use App\Entity\Diplome;
use App\Entity\Competence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserManageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];

        $builder
        ->add('networks', EntityType::class, [
            'label' => false,
            'required' => true,
            'class' => Network::class,
            'choices' => $user->getNetworks(),
            'multiple' => true,
            'expanded' => true
        ])
        ->add('experiences', EntityType::class, [
            'label' => false,
            'required' => true,
            'class' => Experience::class,
            'choices' => $user->getExperiences(),
            'multiple' => true,
            'expanded' => true
        ])
        ->add('diplomes', EntityType::class, [
            'label' => false,
            'required' => true,
            'class' => Diplome::class,
            'choices' => $user->getDiplomes(),
            'multiple' => true,
            'expanded' => true
        ])
        ->add('competences', EntityType::class, [
            'label' => false,
            'required' => true,
            'class' => Competence::class,
            'choices' => $user->getCompetences(),
            'multiple' => true,
            'expanded' => true
        ])
        ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'user' => []
        ]);
    }
}
