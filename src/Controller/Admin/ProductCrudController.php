<?php

namespace App\Controller\Admin;

use App\Entity\Picture;
use App\Entity\Product;
use App\Form\Type\ProductImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use phpDocumentor\Reflection\Types\Boolean;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setPageTitle(Crud::PAGE_INDEX, 'Produits')
        ->setEntityLabelInSingular('Produit')
        ->setEntityLabelInPlural('Produits')
        ->setEntityPermission('ROLE_USER')
        ->setDefaultSort(['id' => 'DESC']);
    }
    
    public function configureFields(string $pageName): iterable
    {
        
        yield AssociationField::new('garage', 'Affiliation Garage');
        yield AssociationField::new('categories', 'Affiliation Catégorie');
        yield AssociationField::new('types', 'Type du produit');
        yield TextField::new('title', 'Titre du produit');
        yield NumberField::new('price', 'Prix');
        yield NumberField::new('quantity', 'Quantité à ajouter');
        yield BooleanField::new('availability', 'Disponibilité');
        yield CollectionField::new('pictures')
            ->setEntryType(ProductImageType::class);
        
    }
    
}
