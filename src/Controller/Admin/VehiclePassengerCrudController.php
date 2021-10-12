<?php

namespace App\Controller\Admin;

use App\Entity\VehiclePassenger;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class VehiclePassengerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return VehiclePassenger::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('vehicle'),
            AssociationField::new('adventurer'),
            IntegerField::new('seat'),
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
                ->add('vehicle')
                ->add('adventurer')
                ->add('seat')
            ;
    }
}
