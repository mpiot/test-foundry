<?php

namespace App\Factory;

use App\Entity\ChangeRequestDocument;
use App\Repository\ChangeRequestDocumentRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<ChangeRequestDocument>
 *
 * @method static ChangeRequestDocument|Proxy                     createOne(array $attributes = [])
 * @method static ChangeRequestDocument[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static ChangeRequestDocument[]|Proxy[]                 createSequence(array|callable $sequence)
 * @method static ChangeRequestDocument|Proxy                     find(object|array|mixed $criteria)
 * @method static ChangeRequestDocument|Proxy                     findOrCreate(array $attributes)
 * @method static ChangeRequestDocument|Proxy                     first(string $sortedField = 'id')
 * @method static ChangeRequestDocument|Proxy                     last(string $sortedField = 'id')
 * @method static ChangeRequestDocument|Proxy                     random(array $attributes = [])
 * @method static ChangeRequestDocument|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ChangeRequestDocument[]|Proxy[]                 all()
 * @method static ChangeRequestDocument[]|Proxy[]                 findBy(array $attributes)
 * @method static ChangeRequestDocument[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 * @method static ChangeRequestDocument[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static ChangeRequestDocumentRepository|RepositoryProxy repository()
 * @method        ChangeRequestDocument|Proxy                     create(array|callable $attributes = [])
 */
final class ChangeRequestDocumentFactory extends ModelFactory
{
    public function asInitial(): self
    {
        return $this->addState([
            'initial' => true,
        ]);
    }

    public function asAdditional(): self
    {
        return $this->addState([
            'initial' => false,
        ]);
    }

    protected function getDefaults(): array
    {
        return [
            'category' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(ChangeRequestDocument $ChangeRequestDocument): void {})
        ;
    }

    protected static function getClass(): string
    {
        return ChangeRequestDocument::class;
    }
}
