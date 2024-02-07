<?php

namespace App\Controller\Admin;

use App\Entity\Type;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Type::class;
    }

    public function configureCrud(Crud $crud): Crud 
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Type')
            ->setEntityLabelInSingular('Type')
            ->setEntityLabelInPlural('Types');
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom');
        yield AssociationField::new('category', 'Nom');
    }
    
}
