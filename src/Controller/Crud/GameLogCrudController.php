<?php

namespace App\Controller\Crud;

use App\Entity\GameLog;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class GameLogCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GameLog::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            DateTimeField::new('date'),
            IntegerField::new('type'),
            AssociationField::new('source'),
            AssociationField::new('target'),
            ArrayField::new('params')
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
                ->add('date')
                ->add('type')
        ;
    }
}
