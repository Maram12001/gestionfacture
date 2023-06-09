<?php

namespace App\Controller\Admin;

use App\Entity\FactureClient;
use App\Entity\FactureFournisseur;
use App\Entity\LigneProduitClient;
use App\Entity\LigneProduitFournisseur;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\RequestStack;

class LigneProduitClientCrudController extends AbstractCrudController
{
    public function __construct(public EntityManagerInterface $entityManager, private RequestStack $requestStack)
    {
    }

    public static function getEntityFqcn(): string
    {
        return LigneProduitClient::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('produit')->setLabel('Produit');
        yield IntegerField::new('quantity', 'Quantité');
        yield MoneyField::new('remise','Remise')->setCurrency('DZD');
        yield NumberField::new('montantTotal', 'Montant total')->setValue(0)
            ->formatValue(fn ($value, $entity) => $this->calculatMontantTotal($entity))->onlyOnIndex();
        yield AssociationField::new('factureClient')->setLabel('Facture')
            ->setFormTypeOption('disabled', true)
            ->hideWhenCreating()->hideOnIndex()->hideOnDetail();

    }

    public function calculatMontantTotal(LigneProduitClient $ligneProduitClient)
    {
        $montant = ($ligneProduitClient->getQuantity() * $ligneProduitClient->getProduit()->getPrixUnitaire()) - $ligneProduitClient->getRemise();
        return number_format($montant, 3);

    }

    public function configureActions(Actions $actions): Actions
    {
        $actions
            ->setPermission(Action::NEW, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::DELETE, 'ROLE_SUPER_ADMIN');

        return $actions;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud);
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $request = $this->requestStack->getCurrentRequest();
        $id = $request->query->get('id');
        $response = $this->entityManager->getRepository(LigneProduitClient::class)->createQueryBuilder('entity');
        $response->where('entity.factureClient = :id ');
        $response->setParameter('id',$id);
        return $response;
    }

    public function getFactureClient()
    {
        $request = $this->requestStack->getCurrentRequest()->query->get('referrer');
        parse_str(parse_url($request, PHP_URL_QUERY), $queryParams);
        if( isset($queryParams['id'])) {
            return $this->entityManager->getRepository(FactureClient::class)->find(['id'=>$queryParams['id']]);
        }else{
            return null;
        }
    }

    public function createEntity(string $entityFqcn)
    {
        $entity = new LigneProduitClient();
        $entity->setFactureClient($this->getFactureClient());
        return $entity;
    }
}
