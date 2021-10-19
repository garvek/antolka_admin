<?php

namespace App\Form\Cartographer;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZoneCreationForm extends AbstractType
{
    private function getRegions($regions): array
    {
        $list = array();
        foreach ($regions as $r) {
            $list[$r->getName()] = $r;
        }
        return $list;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $editMode = $options['edit_mode'];

        $builder
            ->add('name', TextType::class)
            ->add('region', ChoiceType::class, array('choices' => $this->getRegions($options['regions'])))
            ->add($editMode ? 'edit' : 'create', SubmitType::class)
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ZoneCreationData::class,
            'edit_mode' => false,
            'regions' => array(),
        ]);
    }
}
