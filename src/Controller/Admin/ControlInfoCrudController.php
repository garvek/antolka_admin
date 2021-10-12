<?php

namespace App\Controller\Admin;

use App\Entity\ControlInfo;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ControlInfoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ControlInfo::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('user'),
            AssociationField::new('adventurer'),
            TextField::new('lastIp'),
            DateTimeField::new('lastDate'),
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
                ->add('user')
                ->add('adventurer')
                ->add('lastIp')
                ->add('lastDate')
            ;
    }
}
