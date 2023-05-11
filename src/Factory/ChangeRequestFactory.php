<?php

namespace App\Factory;

use App\Entity\CapaChangeRequest;
use App\Entity\ChangeRequest;
use App\Enum\Severity;
use App\Repository\ChangeRequestRepository;
use Zenstruck\Foundry\Instantiator;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<ChangeRequest>
 *
 * @method static ChangeRequest|Proxy                     createOne(array $attributes = [])
 * @method static ChangeRequest[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static ChangeRequest[]|Proxy[]                 createSequence(array|callable $sequence)
 * @method static ChangeRequest|Proxy                     find(object|array|mixed $criteria)
 * @method static ChangeRequest|Proxy                     findOrCreate(array $attributes)
 * @method static ChangeRequest|Proxy                     first(string $sortedField = 'id')
 * @method static ChangeRequest|Proxy                     last(string $sortedField = 'id')
 * @method static ChangeRequest|Proxy                     random(array $attributes = [])
 * @method static ChangeRequest|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ChangeRequest[]|Proxy[]                 all()
 * @method static ChangeRequest[]|Proxy[]                 findBy(array $attributes)
 * @method static ChangeRequest[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 * @method static ChangeRequest[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static ChangeRequestRepository|RepositoryProxy repository()
 * @method        ChangeRequest|Proxy                     create(array|callable $attributes = [])
 */
final class ChangeRequestFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'caseNumber' => self::faker()->numerify('###-###'),
            'additionalDocuments' => ChangeRequestDocumentFactory::new()->asAdditional()->many(1, 3),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function (ChangeRequest $ChangeRequest): void {})
            ->instantiateWith((new Instantiator())->allowExtraAttributes(['additionalDocuments']))
            ->afterInstantiate(function (ChangeRequest $changeRequest, array $attributes): void {
                foreach ($attributes['additionalDocuments'] as $additionalDocument) {
                    $changeRequest->addAdditionalDocument($additionalDocument);
                }
            })
        ;
    }

    protected static function getClass(): string
    {
        return ChangeRequest::class;
    }
}
