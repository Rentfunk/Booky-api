<?php

namespace App\Factory;

use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Classroom>
 *
 * @method static Classroom|Proxy createOne(array $attributes = [])
 * @method static Classroom[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Classroom|Proxy find(object|array|mixed $criteria)
 * @method static Classroom|Proxy findOrCreate(array $attributes)
 * @method static Classroom|Proxy first(string $sortedField = 'id')
 * @method static Classroom|Proxy last(string $sortedField = 'id')
 * @method static Classroom|Proxy random(array $attributes = [])
 * @method static Classroom|Proxy randomOrCreate(array $attributes = [])
 * @method static Classroom[]|Proxy[] all()
 * @method static Classroom[]|Proxy[] findBy(array $attributes)
 * @method static Classroom[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Classroom[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ClassroomRepository|RepositoryProxy repository()
 * @method Classroom|Proxy create(array|callable $attributes = [])
 */
final class ClassroomFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [

        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Classroom $classroom) {})
        ;
    }

    protected static function getClass(): string
    {
        return Classroom::class;
    }
}
