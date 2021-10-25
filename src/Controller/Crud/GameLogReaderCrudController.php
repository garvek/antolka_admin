<?php

namespace App\Controller\Crud;

use App\Entity\GameLogReader;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class GameLogReaderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GameLogReader::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('gameLog')->hideWhenUpdating(),
            AssociationField::new('reader')->hideWhenUpdating(),
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
                ->add('gameLog')
                ->add('reader')
        ;
    }
}
