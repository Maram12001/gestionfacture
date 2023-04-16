<?php

namespace App\Factory;

use App\Entity\FactureFournisseur;
use App\Repository\FactureFournisseurRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<FactureFournisseur>
 *
 * @method        FactureFournisseur|Proxy create(array|callable $attributes = [])
 * @method static FactureFournisseur|Proxy createOne(array $attributes = [])
 * @method static FactureFournisseur|Proxy find(object|array|mixed $criteria)
 * @method static FactureFournisseur|Proxy findOrCreate(array $attributes)
 * @method static FactureFournisseur|Proxy first(string $sortedField = 'id')
 * @method static FactureFournisseur|Proxy last(string $sortedField = 'id')
 * @method static FactureFournisseur|Proxy random(array $attributes = [])
 * @method static FactureFournisseur|Proxy randomOrCreate(array $attributes = [])
 * @method static FactureFournisseurRepository|RepositoryProxy repository()
 * @method static FactureFournisseur[]|Proxy[] all()
 * @method static FactureFournisseur[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static FactureFournisseur[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static FactureFournisseur[]|Proxy[] findBy(array $attributes)
 * @method static FactureFournisseur[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static FactureFournisseur[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class FactureFournisseurFactory extends ModelFactory
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
            'dateEchaence' => self::faker()->dateTime(),
            'dateEmission' => self::faker()->dateTime(),
            'etatComptable' => self::faker()->boolean(),
            'fournisseur' => FournisseurFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(FactureFournisseur $factureFournisseur): void {})
        ;
    }

    protected static function getClass(): string
    {
        return FactureFournisseur::class;
    }
}
