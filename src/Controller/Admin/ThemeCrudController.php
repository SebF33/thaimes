<?php

namespace App\Controller\Admin;

use App\Entity\Theme;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;


class ThemeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Theme::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->overrideTemplate('crud/index', 'admin/crud.html.twig');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            Field::new('title'),
            Field::new('year'),
            Field::new('text')->hideOnIndex(),
            Field::new('catch')->hideOnIndex(),
            AssociationField::new('tags'),
            Field::new('asideText')->hideOnIndex(),
            ImageField::new('picture')
                ->setBasePath('uploads/theme')
                ->setUploadDir('public/uploads/theme')
                ->setFormType(FileUploadType::class)
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            Field::new('pictureAuthor')->hideOnIndex(),
            Field::new('pictureAuthorLink')->hideOnIndex(),
            Field::new('textTwo')->hideOnIndex(),
            Field::new('titleTwo')->hideOnIndex(),
            Field::new('textThree')->hideOnIndex(),
            ImageField::new('pictureTwo')
                ->setBasePath('uploads/theme')
                ->setUploadDir('public/uploads/theme')
                ->setFormType(FileUploadType::class)
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            Field::new('pictureTwoAuthor')->hideOnIndex(),
            Field::new('pictureTwoAuthorLink')->hideOnIndex(),
            Field::new('textFour')->hideOnIndex(),
            IntegerField::new('commentCount', 'Comments')->hideOnForm(),
            BooleanField::new('display')
        ];
    }
}
