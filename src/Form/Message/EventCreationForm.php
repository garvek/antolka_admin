<?php

namespace App\Form\Message;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventCreationForm extends AbstractType
{
    private function getAllowedRecipients($adventurers): array
    {
        $list = array();
        foreach ($adventurers as $adventurer) {
            $list[$adventurer->getName()] = $adventurer;
        }
        return $list;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $editMode = $options['edit_mode'];
        $adventurers = $options['allowed_adventurers'];

        $builder
            ->add('publisher', TextType::class)
            ->add('recipients', CollectionType::class, [
                'entry_type' => ChoiceType::class,
                'entry_options' => [
                    'label' => false,
                    'choices' => $this->getAllowedRecipients($adventurers), 
                ],
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add($editMode ? 'edit' : 'create', SubmitType::class)
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EventCreationData::class,
            'edit_mode' => false,
            'allowed_adventurers' => array(),
        ]);
    }
}
