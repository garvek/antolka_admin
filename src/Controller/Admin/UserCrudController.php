<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('username'),
            TextField::new('email')->hideOnIndex(),
            TextField::new('password')->onlyWhenCreating(),
            ArrayField::new('roles')->hideWhenCreating(),
            DateTimeField::new('created')->hideOnIndex()->hideOnForm(),
            DateTimeField::new('lastDate')->hideOnForm(),
            TextField::new('lastIp')->hideOnForm(),
            BooleanField::new('isVerified'),
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
			->add('username')
			->add('email')
			->add('isVerified')
		;
	}
}
