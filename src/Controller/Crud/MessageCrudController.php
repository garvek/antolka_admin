<?php

namespace App\Controller\Crud;

use App\Entity\Message;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MessageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Message::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextField::new('content'),
            ChoiceField::new('type')->setChoices($this->getMessageTypes()),
            IntegerField::new('tag'),
            DateTimeField::new('published'),
            TextField::new('author'),
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
                    ->add('title')
                    ->add('type')
                    ->add('published')
                    ->add('author')
            ;
    }

    private function getMessageTypes(): array
    {
        return [
            'Global' => Message::TYPE_GLOBAL,
            'Region' => Message::TYPE_REGION,
            'Zone' => Message::TYPE_ZONE,
            'Normal' => Message::TYPE_NORMAL,
            'Special' => Message::TYPE_SPECIAL
        ];
    }
}
