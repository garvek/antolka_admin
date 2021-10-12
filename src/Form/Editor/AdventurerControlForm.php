<?php

namespace App\Form\Editor;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdventurerControlForm extends AbstractType
{
    private function buildChoices(iterable $entities): array
    {
        $choices = array();
        foreach ($entities as $entity) {
            $choices[(string)$entity] = $entity;
        }
        return $choices;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $allowedUsers = $options['allowed_users'];
        $adventurers = $options['adventurers'];
        
        $builder
            ->add('user', ChoiceType::class, array('choices' => $this->buildChoices($allowedUsers)))
            ->add('adventurer', ChoiceType::class, array('choices' => $this->buildChoices($adventurers)))
            ->add('create', SubmitType::class)
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdventurerControlData::class,
            'allowed_users' => array(),
            'adventurers' => array(),
        ]);
    }
}
