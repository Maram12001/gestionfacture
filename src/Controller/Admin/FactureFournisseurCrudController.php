<?php

namespace App\Controller\Admin;

use App\Entity\FactureFournisseur;
use App\Entity\LigneProduitFournisseur;
use App\Form\LigneProduitFournisseurType;
use App\Services\FactureFournisseurServices;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use \EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Service\Attribute\Required;
use  \Symfony\Component\HttpFoundation\RedirectResponse;

class FactureFournisseurCrudController extends AbstractCrudController
{
    #[Required]
    public ParameterBagInterface $parameterBag;

    public function __construct(public EntityManagerInterface $entityManager,
                                private UrlGeneratorInterface $urlGenerator,
                                public FactureFournisseurServices $factureFournisseurServices,
                                public Security $security)
    {
    }

    public static function getEntityFqcn(): string
    {
        return FactureFournisseur::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('id', 'ID')->onlyOnIndex();
        yield DateTimeField::new('dateEmission', 'Date d\'émission')->setFormTypeOptions([
            'disabled' => $this->factureFournisseurServices->isComptableRole()
        ]);
        yield DateTimeField::new('dateEchaence', 'Date d\'échéance')->setFormTypeOptions([
            'disabled' => $this->factureFournisseurServices->isComptableRole()
        ]);
        yield BooleanField::new('etatComptable', 'État comptable');
        yield TextField::new('paiement', 'Mode de paiement')->setFormTypeOptions([
            'disabled' => $this->factureFournisseurServices->isComptableRole()
        ]);
        yield TextField::new('livraison', 'Mode de livraison')->setFormTypeOptions([
            'disabled' => $this->factureFournisseurServices->isComptableRole()
        ]);
        yield AssociationField::new('fournisseur')->setLabel('Fournisseur ')->autocomplete()->hideWhenUpdating();
        yield ArrayField::new('ligneProduitFournisseurs')->hideOnIndex()->hideWhenCreating()->setFormTypeOptions([
            'disabled' => $this->factureFournisseurServices->isComptableRole()
        ]);

    }

    public function configureActions(Actions $actions): Actions
    {
        $showDetails = Action::new('show_details', 'Ligne Produit', 'fa fa-eye')
            ->linkToCrudAction('detailsLigneProduitFournisseur');
        $showDetailsWF = Action::new('show_workflow', 'WorkFlow')
            ->linkToCrudAction('detailsWorkFlow');

        $actions->add(Crud::PAGE_INDEX, $showDetails);
        $actions->add(Crud::PAGE_INDEX, $showDetailsWF);

        $step1 = Action::new('step1', 'Validation par le finance')
            ->linkToCrudAction('verifyFinanceAction')
            ->displayIf(function (FactureFournisseur $ligneProduitFournisseur) {
                return $this->getLastStatus($ligneProduitFournisseur) == "0" && !$this->factureFournisseurServices->isComptableRole();
            });

        $step2 = Action::new('step2', 'Validation par l\'achat')
            ->linkToCrudAction('verifyAchatAction')
            ->displayIf(function (FactureFournisseur $ligneProduitFournisseur) {
                return $this->getLastStatus($ligneProduitFournisseur) == "1" ;

            });

        $step3 = Action::new('step4', 'Validation par le concerné')
            ->linkToCrudAction('verifyAutreAction')
            ->displayIf(function (FactureFournisseur $ligneProduitFournisseur) {
                return$this->getLastStatus($ligneProduitFournisseur) == "2";

            });

        $step4 = Action::new('step3', 'A payer')
            ->linkToCrudAction('payeAction')
            ->displayIf(function (FactureFournisseur $ligneProduitFournisseur) {
                return $this->getLastStatus($ligneProduitFournisseur) == "3" && !$this->factureFournisseurServices->isComptableRole();
            });

        $step5 = Action::new('step5', 'Rejeter')
            ->linkToCrudAction('rejectAction')
            ->displayIf(function (FactureFournisseur $ligneProduitFournisseur) {
                return $this->getLastStatus($ligneProduitFournisseur) == "3" && !$this->factureFournisseurServices->isComptableRole();
            });

        switch (strtolower($this->getUser()->getService()->getNomService())) {
            case 'finance':
                $actions->add(Crud::PAGE_INDEX, $step1)->setPermission('step4','ROLE_ADMIN');
                $actions->add(Crud::PAGE_INDEX, $step4)->setPermission('step4','ROLE_ADMIN');
                $actions->add(Crud::PAGE_INDEX, $step5)->setPermission('step5','ROLE_ADMIN');
                break;
            case 'achat':
                $actions->add(Crud::PAGE_INDEX, $step2)->setPermission('step2','ROLE_USER');
                break;
            default:
                $actions->add(Crud::PAGE_INDEX, $step3)->setPermission('step3','ROLE_USER');
                break;
        }

        $actions
            ->setPermission(Action::NEW, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_COMPTABLE')
            ->setPermission(Action::DELETE, 'ROLE_SUPER_ADMIN');

        return $actions;
    }

    public function detailsLigneProduitFournisseur(AdminContext $context)
    {
        $id = $context->getRequest()->query->get('entityId');
        $url = $this->urlGenerator->generate(
            'dashboard',
            [
                'crudAction'=>'index',
                'crudControllerFqcn' => $this->parameterBag->get('route_ligne_produit'),
                'id' => $id,
            ]
        );

        return $this->redirect($url);
    }

    public function detailsWorkFlow(AdminContext $context)
    {
        $id = $context->getRequest()->query->get('entityId');
        $url = $this->urlGenerator->generate(
            'dashboard',
            [
                'crudAction'=>'index',
                'crudControllerFqcn' => $this->parameterBag->get('route_workflow'),
                'id' => $id,
            ]
        );

        return $this->redirect($url);
    }

    public function getLastStatus(FactureFournisseur $factureFournisseur){

        return $this->factureFournisseurServices->getLastWorkflowPaiementsStatusForFacture($factureFournisseur);
    }

    public function verifyFinanceAction(AdminContext $context): RedirectResponse
    {
        $id = $context->getRequest()->query->get('entityId');
        $facture = $context->getEntity()->getInstance();
        if($this->factureFournisseurServices->addWorkFlow($facture,$this->getUser()->getService(),1))
            $this->addFlash('success','Enregistrement effectué avec succés');

        $url = $this->urlGenerator->generate(
            'dashboard',
            [
                'crudAction'=>'index',
                'crudControllerFqcn' => $this->parameterBag->get('route_facture_fournisseur'),
                'id' => $id,
            ]
        );

        return $this->redirect($url);
    }

    public function verifyAchatAction(AdminContext $context): RedirectResponse
    {
        $id = $context->getRequest()->query->get('entityId');
        $facture = $context->getEntity()->getInstance();
        if($this->factureFournisseurServices->addWorkFlow($facture,$this->getUser()->getService(),2))
            $this->addFlash('success','Enregistrement effectué avec succés');

        $url = $this->urlGenerator->generate(
            'dashboard',
            [
                'crudAction'=>'index',
                'crudControllerFqcn' => $this->parameterBag->get('route_facture_fournisseur'),
                'id' => $id,
            ]
        );

        return $this->redirect($url);
    }

    public function verifyAutreAction(AdminContext $context): RedirectResponse
    {
        $id = $context->getRequest()->query->get('entityId');
        $facture = $context->getEntity()->getInstance();
        if($this->factureFournisseurServices->addWorkFlow($facture,$this->getUser()->getService(),3))
            $this->addFlash('success','Enregistrement effectué avec succés');

        $url = $this->urlGenerator->generate(
            'dashboard',
            [
                'crudAction'=>'index',
                'crudControllerFqcn' => $this->parameterBag->get('route_facture_fournisseur'),
                'id' => $id,
            ]
        );

        return $this->redirect($url);
    }

    public function payeAction(AdminContext $context): RedirectResponse
    {
        $id = $context->getRequest()->query->get('entityId');
        $facture = $context->getEntity()->getInstance();
        if($this->factureFournisseurServices->addWorkFlow($facture,$this->getUser()->getService(),4))
            $this->addFlash('success','Enregistrement effectué avec succés');

        $url = $this->urlGenerator->generate(
            'dashboard',
            [
                'crudAction'=>'index',
                'crudControllerFqcn' => $this->parameterBag->get('route_facture_fournisseur'),
                'id' => $id,
            ]
        );

        return $this->redirect($url);
    }

    public function rejectAction(AdminContext $context): RedirectResponse
    {
        $id = $context->getRequest()->query->get('entityId');
        $facture = $context->getEntity()->getInstance();
        if($this->factureFournisseurServices->addWorkFlow($facture,$this->getUser()->getService(),5))
            $this->addFlash('success','Enregistrement effectué avec succés');

        $url = $this->urlGenerator->generate(
            'dashboard',
            [
                'crudAction'=>'index',
                'crudControllerFqcn' => $this->parameterBag->get('route_facture_fournisseur'),
                'id' => $id,
            ]
        );

        return $this->redirect($url);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        parent::persistEntity($entityManager, $entityInstance);
        if (is_null($this->getLastStatus())) {
            $this->factureFournisseurServices->addWorkFlow($entityInstance, $this->getUser()->getService(), 0);
        }
    }


}
