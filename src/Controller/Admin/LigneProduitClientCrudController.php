<?php

namespace App\Controller\Admin;

use App\Entity\LigneProduitClient;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CurrencyField;
use App\Entity\Produit;

class LigneProduitClientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LigneProduitClient::class;
    }
    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('id', 'ID')->onlyOnIndex();    
      
        yield AssociationField::new('produit')->setLabel('Produit');
     

        
        yield MoneyField::new('prixUnitaire', 'Prix unitaire')->setCurrency('DZD');
      
        yield MoneyField::new('remise')->setCurrency('DZD');
        yield MoneyField::new('montantTotal')->setCurrency('DZD')->onlyOnIndex();
        yield AssociationField::new('factureClient')->setLabel('Facture client');
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
