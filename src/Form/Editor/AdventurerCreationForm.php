<?php

namespace App\Form\Editor;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\AdventurerAttribute;
use App\Form\Type\AttributeAndValueType;

class AdventurerCreationForm extends AbstractType
{
    private function getAllowedAttributes(): array
    {
        return array_flip(AdventurerAttribute::getAttributeTypes());
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $editMode = $options['edit_mode'];
        
        $builder
            ->add('name', TextType::class)
            ->add('x', IntegerType::class)
            ->add('y', IntegerType::class)
            ->add('z', IntegerType::class)
            ->add('attributes', CollectionType::class, [
                'entry_type' => AttributeAndValueType::class,
                'entry_options' => [
                    'label' => false,
                    'allowed_attributes' => $this->getAllowedAttributes(), 
                    'collection_attribute' => true
                ],
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add($editMode ? 'edit' : 'create', SubmitType::class)
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdventurerCreationData::class,
            'edit_mode' => false,
        ]);
    }
}
