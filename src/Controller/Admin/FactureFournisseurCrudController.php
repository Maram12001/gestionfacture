<?php

namespace App\Controller\Admin;

use App\Entity\FactureFournisseur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CurrencyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class FactureFournisseurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FactureFournisseur::class;
    }
    public function configureFields(string $pageName): iterable
    {
        // ...
        yield IntegerField::new('id', 'ID')->onlyOnIndex();
        yield DateTimeField::new('dateEmission', 'Date d\'émission');
        yield DateTimeField::new('dateEchaence', 'Date d\'échéance');
        yield BooleanField::new('etatComptable', 'État comptable');
   
    yield AssociationField::new('fournisseur')->setLabel('Fournisseur');
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
