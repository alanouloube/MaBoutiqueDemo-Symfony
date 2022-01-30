<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('name', 'Nom du produit'),
            SlugField::new('slug', 'URL du produit')
                ->setTargetFieldName('name'),
            ImageField::new('illustration', 'Image du produit')
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            TextField::new('subtitle', 'Description courte')->hideOnIndex(),
            TextareaField::new('description', 'Description détaillée')->hideOnIndex(),
            BooleanField::new('isBest', 'Mise en avant'),
            MoneyField::new('price', 'Prix')
                ->setCurrency('EUR'),
            AssociationField::new('category', 'Catégorie')


        ];
    }
}
