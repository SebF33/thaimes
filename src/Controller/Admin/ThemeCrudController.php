<?php

namespace App\Controller\Admin;

use App\Entity\Theme;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ThemeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Theme::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            Field::new('category'),
            ChoiceField::new('tag')
                ->autocomplete()
                ->setChoices(
                    [
                        'Cinéma' => 'Cinéma',
                        'Site' => 'Site',
                        'Cartes' => 'Cartes',
                        'Dessin' => 'Dessin'
                    ]
                ),
            Field::new('text')->hideOnIndex(),
            ImageField::new('picture')
                ->setBasePath('uploads/theme')
                ->setUploadDir('public/uploads/theme')
                ->setFormType(FileUploadType::class)
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            Field::new('year'),
            BooleanField::new('isInternational'),
            IntegerField::new('commentCount', 'Comments')->hideOnForm()
        ];
    }
}
