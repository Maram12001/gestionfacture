<?php

namespace App\Controller\Admin;

use App\AbstractClass\FactureStatusValues;
use App\Entity\FactureFournisseur;
use App\Entity\LigneProduitFournisseur;
use App\Entity\WorkflowPaiements;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CurrencyField;
use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\RequestStack;

class WorkflowPaiementsCrudController extends AbstractCrudController
{
    public function __construct(public EntityManagerInterface $entityManager, private RequestStack $requestStack)
    {
    }

    public static function getEntityFqcn(): string
    {
        return WorkflowPaiements::class;
    }
    public function configureFields(string $pageName): iterable{

        yield DateTimeField::new('dateEmission', 'date Emission');
        yield TextField::new('statut', 'Statut')
            ->formatValue(fn ($value, $entity) => $this->getStatusLabel($entity->getStatut()));
        yield AssociationField::new('service')->setLabel('Service');
        yield AssociationField::new('factureFournisseur')->setLabel('Facture fournisseur');
    }

    public function getStatusLabel(int $status): string
    {
         return FactureStatusValues::$status[$status] ?? '';
    }
    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->disable('new')
            ->disable('edit')
            ->disable('delete');
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $request = $this->requestStack->getCurrentRequest();
        $id = $request->query->get('id');
        $response = $this->entityManager->getRepository(WorkflowPaiements::class)->createQueryBuilder('entity');
        if (isset($id)) {
            $response->where('entity.factureFournisseur = :id ');
            $response->setParameter('id', $id);
        }
        return $response;
    }
}
