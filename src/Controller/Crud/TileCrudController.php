<?php

namespace App\Controller\Crud;

use App\Entity\Tile;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class TileCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tile::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            IntegerField::new('x'),
            IntegerField::new('y'),
            IntegerField::new('z'),
            IntegerField::new('viewbox')->hideOnIndex(),
            IntegerField::new('collidebox')->hideOnIndex(),
            AssociationField::new('image'),
            IntegerField::new('allowedVehicles'),
            AssociationField::new('zone'),
        ];
    }
	
    public function configureCrud(Crud $crud): Crud
    {
            return $crud
                    ->renderContentMaximized()
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
            return $actions
                    ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ;
    }

    public function configureFilters(Filters $filters): Filters
    {
            return $filters
                    ->add('x')
                    ->add('y')
                    ->add('z')
                    ->add('zone')
                    ->add('allowedVehicles')
            ;
    }
}
