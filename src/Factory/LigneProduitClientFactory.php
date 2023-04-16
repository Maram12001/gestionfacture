<?php

namespace App\Factory;

use App\Entity\LigneProduitClient;
use App\Repository\LigneProduitClientRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<LigneProduitClient>
 *
 * @method        LigneProduitClient|Proxy create(array|callable $attributes = [])
 * @method static LigneProduitClient|Proxy createOne(array $attributes = [])
 * @method static LigneProduitClient|Proxy find(object|array|mixed $criteria)
 * @method static LigneProduitClient|Proxy findOrCreate(array $attributes)
 * @method static LigneProduitClient|Proxy first(string $sortedField = 'id')
 * @method static LigneProduitClient|Proxy last(string $sortedField = 'id')
 * @method static LigneProduitClient|Proxy random(array $attributes = [])
 * @method static LigneProduitClient|Proxy randomOrCreate(array $attributes = [])
 * @method static LigneProduitClientRepository|RepositoryProxy repository()
 * @method static LigneProduitClient[]|Proxy[] all()
 * @method static LigneProduitClient[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static LigneProduitClient[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static LigneProduitClient[]|Proxy[] findBy(array $attributes)
 * @method static LigneProduitClient[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static LigneProduitClient[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class LigneProduitClientFactory extends ModelFactory
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
            'factureClient' => FactureClientFactory::new(),
            'prixUnitaire' => self::faker()->randomFloat(),
            'produit' => ProduitFactory::new(),
            'remise' => self::faker()->randomFloat(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(LigneProduitClient $ligneProduitClient): void {})
        ;
    }

    protected static function getClass(): string
    {
        return LigneProduitClient::class;
    }
}
