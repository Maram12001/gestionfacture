<?php

namespace App\Controller\Admin;

use App\Entity\FactureFournisseur;
use App\Entity\LigneProduitFournisseur;
use App\Services\FactureFournisseurServices;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\EventListener\CrudAutocompleteSubscriber;
use Symfony\Component\HttpFoundation\RequestStack;


class LigneProduitFournisseurCrudController extends AbstractCrudController
{

    public function __construct(public EntityManagerInterface $entityManager,
                                private RequestStack $requestStack,
                                public FactureFournisseurServices $factureFournisseurServices)
    {
    }

    public static function getEntityFqcn(): string
    {
        return LigneProduitFournisseur::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('produit')->setLabel('Produit');
        yield AssociationField::new('factureFournisseur')->setLabel('Facture')
            ->setFormTypeOption('disabled', true)
            ->hideWhenCreating()->hideOnIndex()->hideOnDetail();
        yield IntegerField::new('quantity', 'Quantité');
        yield MoneyField::new('remise','Remise')->setCurrency('DZD');
        yield NumberField::new('montantTotal', 'Montant total')->setValue(0)
            ->formatValue(fn ($value, $entity) => $this->calculatMontantTotalfr($entity))
            ->onlyOnIndex();

    }

    public function calculatMontantTotalFr(LigneProduitFournisseur $ligneProduitFournisseur)
    {
        $montant = ($ligneProduitFournisseur->getQuantity() * $ligneProduitFournisseur->getProduit()->getPrixUnitaire()) - $ligneProduitFournisseur->getRemise();
        $montant = number_format($montant, 2, '.', '');
        dump(floatval($montant));
        return floatval($montant);
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setPageTitle('index','Ligne Produits Fournisseur');
        return parent::configureCrud($crud);
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $request = $this->requestStack->getCurrentRequest();
        $id = $request->query->get('id');
        $response = $this->entityManager->getRepository(LigneProduitFournisseur::class)->createQueryBuilder('entity');
        $response->where('entity.factureFournisseur = :id ');
        $response->setParameter('id',$id);
        return $response;
    }

    public function getFacture()
    {
        $request = $this->requestStack->getCurrentRequest()->query->get('referrer');
        parse_str(parse_url($request, PHP_URL_QUERY), $queryParams);
        if( isset($queryParams['id'])) {
           return $this->entityManager->getRepository(FactureFournisseur::class)->find(['id'=>$queryParams['id']]);
        }else{
            return null;
        }
    }

    public function createEntity(string $entityFqcn)
    {
        $entity = new LigneProduitFournisseur();
        $fournisseur = $this->getFacture();
        $entity->setFactureFournisseur($fournisseur);
        return $entity;
    }

}
