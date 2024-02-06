<?php

namespace App\Controller\Admin;

use App\Entity\Energy;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EnergyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Energy::class;
    }

    public function configureCrud(Crud $crud): Crud 
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Carburant')
            ->setEntityLabelInSingular('Carburant')
            ->setEntityLabelInPlural('Carburants');
    }


    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom');
    }
    
}
