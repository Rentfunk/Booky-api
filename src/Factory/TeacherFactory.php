<?php

namespace App\Factory;

use App\Entity\Teacher;
use App\Repository\TeacherRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Teacher>
 *
 * @method static Teacher|Proxy createOne(array $attributes = [])
 * @method static Teacher[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Teacher|Proxy find(object|array|mixed $criteria)
 * @method static Teacher|Proxy findOrCreate(array $attributes)
 * @method static Teacher|Proxy first(string $sortedField = 'id')
 * @method static Teacher|Proxy last(string $sortedField = 'id')
 * @method static Teacher|Proxy random(array $attributes = [])
 * @method static Teacher|Proxy randomOrCreate(array $attributes = [])
 * @method static Teacher[]|Proxy[] all()
 * @method static Teacher[]|Proxy[] findBy(array $attributes)
 * @method static Teacher[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Teacher[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static TeacherRepository|RepositoryProxy repository()
 * @method Teacher|Proxy create(array|callable $attributes = [])
 */
final class TeacherFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->name(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Teacher $teacher) {})
        ;
    }

    protected static function getClass(): string
    {
        return Teacher::class;
    }
}
