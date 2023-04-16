<?php

namespace App\Controller\Admin;

use App\Entity\FactureClient;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CurrencyField;
use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;


class FactureClientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FactureClient::class;
    }
    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('id', 'ID')->onlyOnIndex();
        yield DateTimeField::new('dateEmission', 'Date d\'émission');
        yield DateTimeField::new('dateEcheance', 'Date d\'échéance');
        yield BooleanField::new('etatComptable', 'État comptable');
        yield AssociationField::new('client')->setLabel('Client');
        yield AssociationField::new('ligneProduitClients')->setLabel('ligneProduitClient');
                    




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
