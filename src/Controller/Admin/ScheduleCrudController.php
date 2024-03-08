<?php

namespace App\Controller\Admin;

use App\Entity\Schedule;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

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
        yield BooleanField::new('close', 'Fermé la journée ?')->hideOnIndex();
        yield BooleanField::new('closedAtLunchtime', 'Fermé le midi ?')->hideOnIndex();
        yield TimeField::new('openingMorning', 'Ouverture du matin');
        yield TimeField::new('closingMorning', 'Fermeture du matin');
        yield TimeField::new('openingAfternoon', 'Ouverture de l\'après midi');
        yield TimeField::new('closingAfternoon', 'Fermeture de l\'après midi');
        
    }
    
}
