<?php

namespace App\Controller\Crud;

use App\Entity\TileImage;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TileImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TileImage::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            IntegerField::new('category'),
            TextField::new('filename'),
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
                    ->add('category')
                    ->add('filename')
            ;
    }
}
