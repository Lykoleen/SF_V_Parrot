<?php

namespace App\Controller\Admin;

use App\Entity\Schedule;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class ScheduleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Schedule::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setPageTitle(Crud::PAGE_INDEX, 'Horaires d\'ouverture')
        ->setEntityLabelInSingular('Journée d\'ouverture')
        ->setEntityLabelInPlural('Horaires d\'ouverture')
        ->setEntityPermission('ROLE_ADMIN');
    }
    
    public function configureFields(string $pageName): iterable
    {
        
        yield AssociationField::new('garage', 'Nom')->hideOnIndex();
        yield TextField::new('day', 'Jour');
        yield BooleanField::new('close', 'Fermé la journée ?')->setFormattedValue(true)->addCssClass('close-schedules')->hideOnIndex();
        yield BooleanField::new('closedAtLunchtime', 'Fermé le midi ?')->addCssClass('close-at-lunch-time')->hideOnIndex();
        yield TimeField::new('openingMorning', 'Ouverture du matin')->addCssClass('opening-morning-div');
        yield TimeField::new('closingMorning', 'Fermeture du matin')->addCssClass('closing-morning-div');
        yield TimeField::new('openingAfternoon', 'Ouverture de l\'après midi')->addCssClass('afternoon-button');
        yield TimeField::new('closingAfternoon', 'Fermeture de l\'après midi')->addCssClass('afternoon-button');
        
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets->addJsFile('js/configSchedulesEasyAdmin.js');
    }
    
}
