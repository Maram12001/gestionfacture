<?php

namespace App\Factory;

use App\Entity\Fournisseur;
use App\Repository\FournisseurRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Fournisseur>
 *
 * @method        Fournisseur|Proxy create(array|callable $attributes = [])
 * @method static Fournisseur|Proxy createOne(array $attributes = [])
 * @method static Fournisseur|Proxy find(object|array|mixed $criteria)
 * @method static Fournisseur|Proxy findOrCreate(array $attributes)
 * @method static Fournisseur|Proxy first(string $sortedField = 'id')
 * @method static Fournisseur|Proxy last(string $sortedField = 'id')
 * @method static Fournisseur|Proxy random(array $attributes = [])
 * @method static Fournisseur|Proxy randomOrCreate(array $attributes = [])
 * @method static FournisseurRepository|RepositoryProxy repository()
 * @method static Fournisseur[]|Proxy[] all()
 * @method static Fournisseur[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Fournisseur[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Fournisseur[]|Proxy[] findBy(array $attributes)
 * @method static Fournisseur[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Fournisseur[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class FournisseurFactory extends ModelFactory
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
            'adresse' => self::faker()->text(50),
            'fax' => self::faker()->randomNumber(),
            'matriculeFiscale' => self::faker()->randomNumber(),
            'raisonSociale' => self::faker()->text(50),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Fournisseur $fournisseur): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Fournisseur::class;
    }
}
