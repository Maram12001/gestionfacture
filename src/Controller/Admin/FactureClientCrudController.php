<?php

namespace App\Controller\Admin;

use App\Entity\FactureClient;
use App\Services\FactureFournisseurServices;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CurrencyField;
use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Service\Attribute\Required;


class FactureClientCrudController extends AbstractCrudController
{

    #[Required]
    public ParameterBagInterface $parameterBag;

    public function __construct(private UrlGeneratorInterface $urlGenerator, public FactureFournisseurServices $factureFournisseurServices)
    {
    }

    public static function getEntityFqcn(): string
    {
        return FactureClient::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('id', 'ID')->onlyOnIndex();
        yield DateTimeField::new('dateEmission', 'Date d\'émission')->setFormTypeOptions([
            'disabled' => $this->factureFournisseurServices->isComptableRole()
        ]);;
        yield DateTimeField::new('dateEcheance', 'Date d\'échéance')->setFormTypeOptions([
            'disabled' => $this->factureFournisseurServices->isComptableRole()
        ]);;
        yield DateTimeField::new('dateEcheance', 'Date d\'échéance')->setFormTypeOptions([
            'disabled' => $this->factureFournisseurServices->isComptableRole()
        ]);;
        yield TextField::new('paiement', 'Mode de paiement')->setFormTypeOptions([
            'disabled' => $this->factureFournisseurServices->isComptableRole()
        ]);;
        yield TextField::new('livraison', 'Mode de livraison')->setFormTypeOptions([
            'disabled' => $this->factureFournisseurServices->isComptableRole()
        ]);;
        yield AssociationField::new('client')->setLabel('Client')->setFormTypeOptions([
            'disabled' => $this->factureFournisseurServices->isComptableRole()
        ]);;
        yield BooleanField::new('etatComptable', 'État comptable')->setFormTypeOptions([
            'disabled' => !$this->factureFournisseurServices->isComptableRole()
        ]);;

    }

    public function configureActions(Actions $actions): Actions
    {
        $showDetails = Action::new('show_details', 'Détails')
            ->linkToCrudAction('detailsLigneProduitClient');
        $actions
            ->setPermission(Action::NEW, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_COMPTABLE')
            ->setPermission(Action::DELETE, 'ROLE_SUPER_ADMIN');

        return $actions->add(Crud::PAGE_INDEX, $showDetails);
    }

    public function detailsLigneProduitClient(AdminContext $context)
    {
        $id = $context->getRequest()->query->get('entityId');
        $url = $this->urlGenerator->generate(
            'dashboard',
            [
                'crudAction'=>'index',
                'crudControllerFqcn' =>$this->parameterBag->get('route_ligne_client'),
                'id' => $id,
            ]
        );

        return $this->redirect($url);
    }
}
