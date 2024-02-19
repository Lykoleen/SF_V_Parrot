<?php

namespace App\Controller\Admin;

use App\Entity\Vehicle;
use App\Form\Type\ProductImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class VehicleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Vehicle::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setPageTitle(Crud::PAGE_INDEX, 'Véhicules')
        ->setEntityLabelInSingular('Véhicule')
        ->setEntityLabelInPlural('Véhicules')
        ->setDefaultSort(['id' => 'DESC']);
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('garage', 'Affiliation Garage')->hideOnIndex();
        yield AssociationField::new('categories', 'Catégorie Associée');
        yield TextField::new('title', 'Titre de l\'annonce');
        yield AssociationField::new('types', 'Type du véhicule');
        yield NumberField::new('price', 'Prix');
        yield IntegerField::new('years', 'Année');
        yield IntegerField::new('mileage', 'kilométrage');
        yield AssociationField::new('brands', 'Marque');
        yield AssociationField::new('models', 'Modèle');
        yield AssociationField::new('gearboxes', 'Boîte de vitesse');
        yield AssociationField::new('energies', 'Carburant');
        yield TextareaField::new('description', 'Description')->hideOnIndex();
        yield CollectionField::new('pictures')
            ->setEntryType(ProductImageType::class)->hideOnIndex();

    }
    
}
