<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use App\Form\Type\ServiceImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    public function configureCrud(Crud $crud): Crud 
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Services')
            ->setEntityLabelInSingular('Service')
            ->setEntityLabelInPlural('Services');
    }

    public function configureFields(string $pageName): iterable
    {
        $mappingsParams = $this->getParameter('vich_uploader.mappings');
        $serviceImagePath = $mappingsParams['service']['uri_prefix'];

        yield TextField::new('title', 'Nom');
        yield TextEditorField::new('description', 'Description');
        yield CollectionField::new('pictures')
            ->setEntryType(ServiceImageType::class);   
    }
    
}
