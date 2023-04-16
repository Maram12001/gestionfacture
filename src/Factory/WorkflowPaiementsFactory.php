<?php
namespace App\Factory;

use App\Entity\WorkflowPaiements;
use App\Repository\WorkflowPaiementsRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<WorkflowPaiements>
 *
 * @method        WorkflowPaiements|Proxy create(array|callable $attributes = [])
 * @method static WorkflowPaiements|Proxy createOne(array $attributes = [])
 * @method static WorkflowPaiements|Proxy find(object|array|mixed $criteria)
 * @method static WorkflowPaiements|Proxy findOrCreate(array $attributes)
 * @method static WorkflowPaiements|Proxy first(string $sortedField = 'id')
 * @method static WorkflowPaiements|Proxy last(string $sortedField = 'id')
 * @method static WorkflowPaiements|Proxy random(array $attributes = [])
 * @method static WorkflowPaiements|Proxy randomOrCreate(array $attributes = [])
 * @method static WorkflowPaiementsRepository|RepositoryProxy repository()
 * @method static WorkflowPaiements[]|Proxy[] all()
 * @method static WorkflowPaiements[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static WorkflowPaiements[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static WorkflowPaiements[]|Proxy[] findBy(array $attributes)
 * @method static WorkflowPaiements[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static WorkflowPaiements[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class WorkflowPaiementsFactory extends ModelFactory
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
            'dateEmission' => self::faker()->dateTime(),
            'dateReception' => self::faker()->dateTime(),
            'factureFournisseur' => FactureFournisseurFactory::new(),
            'service' => ServiceFactory::new(),
            'statut' => self::faker()->text(50),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(WorkflowPaiements $workflowPaiements): void {})
        ;
    }

    protected static function getClass(): string
    {
        return WorkflowPaiements::class;
    }
}
