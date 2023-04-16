<?php

namespace App\Factory;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Produit>
 *
 * @method        Produit|Proxy create(array|callable $attributes = [])
 * @method static Produit|Proxy createOne(array $attributes = [])
 * @method static Produit|Proxy find(object|array|mixed $criteria)
 * @method static Produit|Proxy findOrCreate(array $attributes)
 * @method static Produit|Proxy first(string $sortedField = 'id')
 * @method static Produit|Proxy last(string $sortedField = 'id')
 * @method static Produit|Proxy random(array $attributes = [])
 * @method static Produit|Proxy randomOrCreate(array $attributes = [])
 * @method static ProduitRepository|RepositoryProxy repository()
 * @method static Produit[]|Proxy[] all()
 * @method static Produit[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Produit[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Produit[]|Proxy[] findBy(array $attributes)
 * @method static Produit[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Produit[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class ProduitFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'designation' => self::faker()->text(50),
            'prixUnitaire' => self::faker()->randomFloat(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Produit $produit): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Produit::class;
    }
}
