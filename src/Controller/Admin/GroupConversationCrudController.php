<?php

namespace App\Controller\Admin;

use App\Entity\GroupConversation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;


class GroupConversationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GroupConversation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->overrideTemplate('crud/index', 'admin/crud.html.twig');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            Field::new('name'),
        ];
    }
}
