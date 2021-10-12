<?php

namespace App\Form\Type;

use App\Form\Type\AttributeAndValueData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttributeAndValueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('attribute', ChoiceType::class, [
                'choices' => $options['allowed_attributes'],
                'required' => !$options['collection_attribute'],
            ])
            ->add('value', IntegerType::class, [
                'required' => !$options['collection_attribute'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AttributeAndValueData::class,
            'allowed_attributes' => array(),
            'collection_attribute' => false,
        ]);
    }
}
