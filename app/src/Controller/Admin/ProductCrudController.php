<?php

namespace App\Controller\Admin;

use App\Entity\{
    Image, Product
};
use App\Field\MultipleImagesField;
use EasyCorp\Bundle\EasyAdminBundle\Config\{
    Crud, Filters
};
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Product')
            ->setEntityLabelInPlural('Products')
            ->setSearchFields(['id', 'price', 'title', 'description']);
    }

    public function configureFields(string $pageName): iterable
    {
        $title = TextField::new('title');
        $description = TextareaField::new('description');
        $categories = AssociationField::new('category');

        $price = NumberField::new('price');
        $id = IntegerField::new('id', 'ID');
        $images = CollectionField::new('images')
            ->setEntryType (Image::class)
            ->allowAdd (false);
        $multipleImages = MultipleImagesField::new('multipleImages')
            ->setFormTypeOption('attr.multiple', 'multiple')
            ->setFormTypeOption('label', " ")
            ->setVirtual(true);

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $title, $price];
        }

        return [
            FormField::addPanel('Basic information'),
            $title,
            SlugField::new('slug')->setTargetFieldName('title')
                ->setFormattedValue(function ($value) {
                    return strtoupper($value);
                }),
            $description, $categories->autocomplete(),
            FormField::addPanel('Product Details'),
            $price,
            FormField::addPanel('Attachments'),
            $images, $multipleImages,
        ];
    }
}