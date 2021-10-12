<?php

namespace App\Controller\Admin;

use App\Entity\Zone;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ZoneCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Zone::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            AssociationField::new('region'),
            BooleanField::new('crimeAllowed')->hideOnIndex(),
            BooleanField::new('combatAllowed')->hideOnIndex(),
            BooleanField::new('searchAllowed')->hideOnIndex(),
            BooleanField::new('cropAllowed')->hideOnIndex(),
            BooleanField::new('shoutAllowed')->hideOnIndex(),
            BooleanField::new('radioAllowed')->hideOnIndex(),
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
                    ->add('name')
                    ->add('region')
            ;
    }
}
