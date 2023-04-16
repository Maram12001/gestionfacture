<?php

namespace App\Controller\Admin;

use App\Entity\WorkflowPaiements;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CurrencyField;
use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
class WorkflowPaiementsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WorkflowPaiements::class;
    }
    public function configureFields(string $pageName): iterable{
    yield IntegerField::new('id', 'ID')->onlyOnIndex();
yield DateTimeField::new('dateReception', 'date Reception');
yield DateTimeField::new('dateEmission', 'date Emission');
yield TextField::new('statut', 'Statut');
yield AssociationField::new('service')->setLabel('Service');
yield AssociationField::new('factureFournisseur')->setLabel('Facture fournisseur');
}

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
