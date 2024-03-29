<?php

namespace App\Controller\Admin;

use App\Entity\Gearbox;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GearboxCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Gearbox::class;
    }

    public function configureCrud(Crud $crud): Crud 
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Boîte de vitesse')
            ->setEntityLabelInSingular('Boîte de vitesse')
            ->setEntityLabelInPlural('Boîtes de vitesse');
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom');
    }
    
}
