<?php

namespace App\Controller\Admin;

use App\Entity\Vehicle;
use App\Form\Type\ProductImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
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
        yield AssociationField::new('garage', 'Affiliation Garage');
        yield AssociationField::new('categories', 'Catégorie Associée');
        yield AssociationField::new('categories', 'Affiliation Catégorie');
        yield AssociationField::new('types', 'Type du véhicule');
        yield TextField::new('title', 'Titre de l\'annonce');
        yield NumberField::new('price', 'Prix');
        yield AssociationField::new('brands', 'Marque');
        yield AssociationField::new('models', 'Modèle');
        yield AssociationField::new('gearboxes', 'Boîte de vitesse');
        yield AssociationField::new('energies', 'Carburant');
        yield CollectionField::new('pictures')
            ->setEntryType(ProductImageType::class);

    }
    
}
