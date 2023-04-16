<?php

namespace App\Factory;

use App\Entity\FactureClient;
use App\Repository\FactureClientRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<FactureClient>
 *
 * @method        FactureClient|Proxy create(array|callable $attributes = [])
 * @method static FactureClient|Proxy createOne(array $attributes = [])
 * @method static FactureClient|Proxy find(object|array|mixed $criteria)
 * @method static FactureClient|Proxy findOrCreate(array $attributes)
 * @method static FactureClient|Proxy first(string $sortedField = 'id')
 * @method static FactureClient|Proxy last(string $sortedField = 'id')
 * @method static FactureClient|Proxy random(array $attributes = [])
 * @method static FactureClient|Proxy randomOrCreate(array $attributes = [])
 * @method static FactureClientRepository|RepositoryProxy repository()
 * @method static FactureClient[]|Proxy[] all()
 * @method static FactureClient[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static FactureClient[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static FactureClient[]|Proxy[] findBy(array $attributes)
 * @method static FactureClient[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static FactureClient[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class FactureClientFactory extends ModelFactory
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
            'client' => ClientFactory::new(),
            'dateEcheance' => self::faker()->dateTime(),
            'dateEmission' => self::faker()->dateTime(),
            'etatComptable' => self::faker()->boolean(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(FactureClient $factureClient): void {})
        ;
    }

    protected static function getClass(): string
    {
        return FactureClient::class;
    }
}
