<?php

namespace App\Form\Message;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InfoZoneCreationForm extends AbstractType
{
    private function getListZones($zones): array
    {
        $list = array();
        foreach ($zones as $z) {
            $list[$z->getName()] = $z;
        }
        return $list;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $editMode = $options['edit_mode'];

        $builder
            ->add('zone', ChoiceType::class, array('choices' => $this->getListZones($options['zones'])))
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add($editMode ? 'edit' : 'create', SubmitType::class)
        ;

        if ($editMode) {
            $builder->get('zone')->setDisabled(true);
        }
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InfoZoneCreationData::class,
            'edit_mode' => false,
            'zones' => array(),
        ]);
    }
}
