<?php

namespace App\Controller\Crud;

use App\Entity\AdventurerAttribute;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class AdventurerAttributeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AdventurerAttribute::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            IntegerField::new('attribute')->hideWhenUpdating(),
            IntegerField::new('value'),
            AssociationField::new('adventurer')->hideWhenUpdating(),
        ];
    }
	
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->renderContentMaximized()
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
                ->add('attribute')
                ->add('adventurer')
        ;
    }
}
