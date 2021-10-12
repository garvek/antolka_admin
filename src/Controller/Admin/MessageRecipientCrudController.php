<?php

namespace App\Controller\Admin;

use App\Entity\MessageRecipient;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class MessageRecipientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MessageRecipient::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('recipient'),
            AssociationField::new('message'),
            BooleanField::new('opened'),
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
                ->add('recipient')
                ->add('message')
                ->add('opened')
            ;
    }
}
